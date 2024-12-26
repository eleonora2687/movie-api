<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\TVShow;

class FetchMoviesAndTVshows extends Command
{
    protected $signature = 'fetch:movies-tvshows';
    protected $description = 'Fetch movies and TV shows from TMDB and store in database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Fetching movies...');
        $this->fetchMovies();

        $this->info('Fetching TV shows...');
        $this->fetchTVShows();

        $this->info('Done fetching movies and TV shows!');
        return 0;
    }

    private function fetchMovies()
    {
        $this->fetchPopularMovies();
        $this->fetchUpcomingMovies();
        $this->fetchTopRatedMovies();
    }

    private function fetchPopularMovies()
    {
        $this->fetchAndStoreMovies('https://api.themoviedb.org/3/movie/popular', 100, 'popular');
    }

    private function fetchUpcomingMovies()
    {
        $this->fetchAndStoreMovies('https://api.themoviedb.org/3/movie/upcoming', 100, 'upcoming');
    }

    private function fetchTopRatedMovies()
    {
        $this->fetchAndStoreMovies('https://api.themoviedb.org/3/movie/top_rated', 100, 'top_rated');
    }

    private function fetchAndStoreMovies($url, $limit, $category)
    {
        $fetchedMovies = 0;
        $page = 1;

        // Fetch genre list
        $genreMap = $this->fetchGenres('movie');

        while ($fetchedMovies < $limit) {
            $response = Http::get($url, [
                'api_key' => env('TMDB_API_KEY'),
                'page' => $page,
            ]);

            if ($response->successful()) {
                $movies = $response->json()['results'];

                if (count($movies) == 0) {
                    break;
                }

                foreach ($movies as $movie) {
                    $releaseDate = $this->formatReleaseDate($movie['release_date']);

                    // Check if the release date is today or in the future ONLY for the 'upcoming' category
                    if ($category === 'upcoming' && strtotime($releaseDate) >= strtotime('today')) {
                        $runtime = $this->fetchMovieDetails($movie['id']);
                        $formattedRuntime = $this->formatRuntime($runtime);

                        // Map genre IDs to names
                        $categories = isset($movie['genre_ids']) 
                            ? $this->mapGenreIdsToNames($movie['genre_ids'], $genreMap) 
                            : null;

                        Movie::updateOrCreate(
                            ['id' => $movie['id']],
                            [
                                'title' => $movie['title'],
                                'poster_url' => isset($movie['poster_path']) ? 'https://image.tmdb.org/t/p/w200' . $movie['poster_path'] : null,
                                'release_date' => $releaseDate,
                                'categories' => $categories, // Store genres as names
                                'duration' => $formattedRuntime,
                                'rating' => $movie['vote_average'],
                                'overview' => $movie['overview'],
                                'is_favorite' => false,
                                'category' => $category,
                            ]
                        );
                        $fetchedMovies++;
                    }

                    // If the category is not 'upcoming', just store the movie
                    if ($category !== 'upcoming') {
                        $runtime = $this->fetchMovieDetails($movie['id']);
                        $formattedRuntime = $this->formatRuntime($runtime);

                        // Map genre IDs to names
                        $categories = isset($movie['genre_ids']) 
                            ? $this->mapGenreIdsToNames($movie['genre_ids'], $genreMap) 
                            : null;

                        Movie::updateOrCreate(
                            ['id' => $movie['id']],
                            [
                                'title' => $movie['title'],
                                'poster_url' => isset($movie['poster_path']) ? 'https://image.tmdb.org/t/p/w200' . $movie['poster_path'] : null,
                                'release_date' => $releaseDate,
                                'categories' => $categories, // Store genres as names
                                'duration' => $formattedRuntime,
                                'rating' => $movie['vote_average'],
                                'overview' => $movie['overview'],
                                'is_favorite' => false,
                                'category' => $category,
                            ]
                        );
                        $fetchedMovies++;
                    }
                }

                $page++;
            } else {
                $this->error('Failed to fetch movies: ' . $response->status());
                break;
            }
        }
    }


    private function fetchTVShows()
    {
        $this->fetchPopularTVShows();
        $this->fetchOnTheAirTVShows();
        $this->fetchTopRatedTVShows();
    }

    private function fetchPopularTVShows()
    {
        $this->fetchAndStoreTVShows('https://api.themoviedb.org/3/tv/popular', 100, 'popular');
    }

    private function fetchOnTheAirTVShows()
    {
        $this->fetchAndStoreTVShows('https://api.themoviedb.org/3/tv/on_the_air', 100, 'on_the_air');
    }

    private function fetchTopRatedTVShows()
    {
        $this->fetchAndStoreTVShows('https://api.themoviedb.org/3/tv/top_rated', 100, 'top_rated');
    }

    private function fetchAndStoreTVShows($url, $limit, $category)
    {
        $fetchedTVShows = 0;
        $page = 1;

        // Fetch genre list for TV shows
        $genreMap = $this->fetchGenres('tv');

        while ($fetchedTVShows < $limit) {
            $response = Http::get($url, [
                'api_key' => env('TMDB_API_KEY'),
                'page' => $page,
            ]);

            if ($response->successful()) {
                $tvShows = $response->json()['results'];

                // If there are no more results, stop the loop
                if (count($tvShows) == 0) {
                    break;
                }

                foreach ($tvShows as $tvShow) {
                    // Map genre IDs to names
                    $categories = isset($tvShow['genre_ids']) 
                        ? $this->mapGenreIdsToNames($tvShow['genre_ids'], $genreMap) 
                        : null;

                    TVShow::updateOrCreate(
                        ['id' => $tvShow['id']],
                        [
                            'title' => $tvShow['name'],
                            'poster_url' => isset($tvShow['poster_path']) 
                                ? 'https://image.tmdb.org/t/p/w200' . $tvShow['poster_path'] 
                                : null,
                            'release_date' => isset($tvShow['first_air_date']) 
                                ? (strlen($tvShow['first_air_date']) == 4 
                                    ? $tvShow['first_air_date'] . '-01-01' 
                                    : date('Y-m-d', strtotime($tvShow['first_air_date']))) 
                                : null,
                            'categories' => $categories, // Store genres as names
                            'rating' => $tvShow['vote_average'],
                            'overview' => $tvShow['overview'], // Correct this line
                            'category' => $category, // Store the category
                            'is_favorite' => false, // Default to false if not provided
                        ]
                    );
                }

                $fetchedTVShows += count($tvShows);
                $page++; // Move to the next page
            } else {
                $this->error('Failed to fetch TV shows: ' . $response->status());
                break;
            }
        }
    }


    private function fetchMovieDetails($movieId)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/' . $movieId, [
            'api_key' => env('TMDB_API_KEY'),
        ]);

        if ($response->successful()) {
            $movieDetails = $response->json();
            return $movieDetails['runtime'] ?? null; // Return runtime (in minutes)
        }

        $this->error('Failed to fetch movie details for ID ' . $movieId);
        return null;
    }

    private function formatRuntime($runtime)
    {
        if ($runtime === null) {
            return null;
        }

        $hours = intdiv($runtime, 60); // Calculate hours
        $minutes = $runtime % 60; // Calculate minutes
        return "{$hours}h {$minutes}m"; // Return formatted runtime
    }

    private function formatReleaseDate($releaseDate)
    {
        try {
            $date = new \DateTime($releaseDate, new \DateTimeZone('UTC')); // TMDB dates are in UTC
            $date->setTimezone(new \DateTimeZone('Europe/Athens')); // Convert to Greek timezone
            return $date->format('Y-m-d'); // Format as YYYY-MM-DD
        } catch (\Exception $e) {
            $this->error('Failed to format release date: ' . $e->getMessage());
            return null; // Return null if formatting fails
        }
    }

    private function fetchGenres($type = 'movie')
    {
        $response = Http::get("https://api.themoviedb.org/3/genre/{$type}/list", [
            'api_key' => env('TMDB_API_KEY'),
        ]);

        if ($response->successful()) {
            $genres = $response->json()['genres'];
            $genreMap = [];

            foreach ($genres as $genre) {
                $genreMap[$genre['id']] = $genre['name'];
            }

            return $genreMap; // Return as [id => name]
        }

        $this->error("Failed to fetch {$type} genres.");
        return [];
    }


    private function mapGenreIdsToNames($genreIds, $genreMap)
    {
        $names = [];

        foreach ($genreIds as $id) {
            if (isset($genreMap[$id])) {
                $names[] = $genreMap[$id];
            }
        }

        return implode(', ', $names); // Convert to comma-separated string
    }


}
