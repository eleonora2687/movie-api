<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\TVShow;
use Illuminate\Support\Collection;

class MovieController extends Controller
{

    public function popularMovies(Request $request)
    {
        // Get the sort parameter from the query string, default to 'default' if not set
        $sort = $request->query('sort', 'default');
    
        // Build the query for movies
        $query = Movie::where('category', 'popular');
    
        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity_asc':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'popularity_desc':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'release_date_asc':
                    $query->orderBy('release_date', 'asc');
                    break;
                case 'release_date_desc':
                    $query->orderBy('release_date', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'asc'); // Default sorting if no sort option is selected
                    break;
            }
        }
    
        // Get the paginated results
        $movies = $query->paginate(20)->appends(['sort' => $sort]);
    
        // Return the view and pass the movies and sort variables
        return view('movies.popular-movies', compact('movies', 'sort'));
    }
    

    public function showPopularMovie($id)
    {
        $movie = Movie::findOrFail($id); 

        return view('movies.single-movie', compact('movie'));
    }

    public function showUpcomingMovie($id)
    {
        $movie = Movie::findOrFail($id); 

        return view('movies.single-movie', compact('movie'));
    }

    public function showTopRatedMovie($id)
    {
        $movie = Movie::findOrFail($id); 

        return view('movies.single-movie', compact('movie'));
    }

    public function showAllMovie($id)
    {
        $movie = Movie::findOrFail($id); 

        return view('movies.single-movie', compact('movie'));
    }



    public function upcomingMovies(Request $request)
    {
        // Get the sort parameter from the query string, default to 'default' if not set
        $sort = $request->query('sort', 'default');
    
        // Build the query for movies
        $query = Movie::where('category', 'upcoming');
    
        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity_asc':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'popularity_desc':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'release_date_asc':
                    $query->orderBy('release_date', 'asc');
                    break;
                case 'release_date_desc':
                    $query->orderBy('release_date', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'asc'); // Default sorting if no sort option is selected
                    break;
            }
        }
    
        // Get the paginated results
        $movies = $query->paginate(20)->appends(['sort' => $sort]);
    
        // Return the view and pass the movies and sort variables
        return view('movies.upcoming-movies', compact('movies', 'sort'));
}


    public function topRatedMovies(Request $request)
    {
        // Get the sort parameter from the query string, default to 'default' if not set
        $sort = $request->query('sort', 'default');
    
        // Build the query for movies
        $query = Movie::where('category', 'top_rated');
    
        // Handle sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity_asc':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'popularity_desc':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'release_date_asc':
                    $query->orderBy('release_date', 'asc');
                    break;
                case 'release_date_desc':
                    $query->orderBy('release_date', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'asc'); // Default sorting if no sort option is selected
                    break;
            }
        }
    
        // Get the paginated results
        $movies = $query->paginate(20)->appends(['sort' => $sort]);
    
        // Return the view and pass the movies and sort variables
        return view('movies.top-rated-movies', compact('movies', 'sort'));
        
    }

        public function allFavorites()
    {
        $movieFavorites = Movie::where('is_favorite', 1)->paginate(10);
        $tvShowFavorites = TVShow::where('is_favorite', 1)->paginate(10);

        // Merge the two paginated results
        $mergedFavorites = $movieFavorites->merge($tvShowFavorites);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        $items = $mergedFavorites->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $favorites = new LengthAwarePaginator($items, $mergedFavorites->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('favorites.all-favorite', compact('favorites'));
    }



    public function allMovies(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $search = $request->query('search', '');

        // Build the query
        $query = Movie::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Handle sorting
        switch ($sort) {
            case 'popularity_asc':
                $query->orderBy('rating', 'asc');
                break;
            case 'popularity_desc':
                $query->orderBy('rating', 'desc');
                break;
            case 'release_date_asc':
                $query->orderBy('release_date', 'asc');
                break;
            case 'release_date_desc':
                $query->orderBy('release_date', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
                break;
        }

        // Paginate results
        $movies = $query->paginate(20)->appends(['sort' => $sort, 'search' => $search]);

        return view('movies.all-movies', compact('movies', 'sort', 'search'));
    }

    
}
