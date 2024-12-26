<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; 
use App\Models\TVShow;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('query');
    $category = $request->input('category'); // Can be null for all categories
    $type = $request->input('type'); // 'movies', 'tv_shows', or 'all'

    if (!$query || !$type) {
        return response()->json(['error' => 'Invalid search parameters'], 400);
    }

    $results = [];

    if ($type === 'movies') {
        $results = Movie::where('title', 'LIKE', "%{$query}%")
            ->when($category, function ($queryBuilder) use ($category) {
                return $queryBuilder->where('category', $category);
            })
            ->select('id', 'title')
            ->distinct()
            ->get();
    } elseif ($type === 'tv_shows') {
        $results = TVShow::where('title', 'LIKE', "%{$query}%")
            ->when($category, function ($queryBuilder) use ($category) {
                return $queryBuilder->where('category', $category);
            })
            ->select('id', 'title')
            ->distinct()
            ->get();
    } elseif ($type === 'all') {
        $movies = Movie::where('title', 'LIKE', "%{$query}%")
            ->select('id', 'title', DB::raw("'movies' as type"))
            ->distinct()
            ->get();
    
        $tvShows = TVShow::where('title', 'LIKE', "%{$query}%")
            ->select('id', 'title', DB::raw("'t_v_shows' as type"))
            ->distinct()
            ->get();
    
        $results = $movies->merge($tvShows);
    }

    return response()->json($results);
}

}
