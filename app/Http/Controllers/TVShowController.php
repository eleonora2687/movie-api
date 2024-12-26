<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;
use App\Models\TVShow;
use Illuminate\Support\Collection;

class TVShowController extends Controller
{
    public function popularTVShows(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $query = TVShow::where('category', 'popular');

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
        }

        $tvshows = $query->paginate(20)->appends(['sort' => $sort]);
        return view('tv-shows.popular-tv-shows', compact('tvshows', 'sort'));
    }

    public function allTVShows(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $search = $request->query('search', '');

        // Build the query
        $query = TVShow::query();

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
        $tvshows = $query->paginate(20)->appends(['sort' => $sort, 'search' => $search]);

        return view('tv-shows.all-tv-shows', compact('tvshows', 'sort', 'search'));
    }

    public function showAllTVShow($id)
    {
        $tvshow = TVShow::findOrFail($id); 

        return view('tv-shows.single-tv-show', compact('tvshow'));
    }


    public function showPopularTVShow($id)
    {
        $tvshow = TVShow::findOrFail($id); 

        return view('tv-shows.single-tv-show', compact('tvshow'));
    }

    public function onTheAirTVShows(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $query = TVShow::where('category', 'on_the_air');

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
        }

        $tvshows = $query->paginate(20)->appends(['sort' => $sort]);
        return view('tv-shows.on-the-air-tv-shows', compact('tvshows', 'sort'));
    }

    public function showOnTheAirTVShow($id)
    {
        $tvshow = TVShow::findOrFail($id); 

        return view('tv-shows.single-tv-show', compact('tvshow'));
    }

    public function topRatedTVShows(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $query = TVShow::where('category', 'top_rated');

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
        }

        $tvshows = $query->paginate(20)->appends(['sort' => $sort]);
        return view('tv-shows.top-rated-tv-shows', compact('tvshows', 'sort'));
    }

    public function showTopRatedTVShow($id)
    {
        $tvshow = TVShow::findOrFail($id); 

        return view('tv-shows.single-tv-show', compact('tvshow'));
    }
}
