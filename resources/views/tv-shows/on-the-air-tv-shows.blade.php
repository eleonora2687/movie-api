@extends('layouts.app')

@section('title', 'On the Air TV Shows')

@section('content')
<div class="text-center mt-5 position-relative">
    <h1 class="mb-3">On the Air TV Shows</h1>
</div>

<x-sorting-and-search-bar 
:sortOptions="[
    'popularity_desc' => 'Rating (Descending)',
    'popularity_asc' => 'Rating (Ascending)',
    'release_date_asc' => 'Release Date (Oldest)',
    'release_date_desc' => 'Release Date (Newest)',
    'title_asc' => 'Title (A-Z)',
    'title_desc' => 'Title (Z-A)',
]" 
:sort="$sort"   
placeholder="Search On the Air TV Shows by Title..." 
:searchRoute="route('search')" />

@foreach ($tvshows as $tvshow)
    @include('components.movie-card', [
        'id' => $tvshow->id,
        'poster_url' => $tvshow->poster_url,
        'title' => $tvshow->title,
        'release_date' => $tvshow->release_date,
        'categories' => $tvshow->categories, 
        'rating' => $tvshow->rating,
        'overview' => Str::limit($tvshow->overview, 500, '...'),
        'is_favorite' => $tvshow->is_favorite,
        'type' => 'tvshow' 

    ])

@endforeach

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <!-- Showing results text -->
    <div class="text-muted d-none d-sm-block">
        Showing {{ $tvshows->firstItem() }} to {{ $tvshows->lastItem() }} of {{ $tvshows->total() }} results
    </div>

    <!-- Pagination section -->
    <nav aria-label="Movies Pagination" class="w-100">
        <div class="d-flex justify-content-end w-100">
            <div class="pagination-container">
                {{ $tvshows->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </nav>
</div>

@endsection
