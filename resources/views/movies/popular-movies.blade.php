@extends('layouts.app')

@section('title', 'Popular Movies')

@section('content')
<div class="text-center mt-5 position-relative">
    <h1 class="mb-3">Popular Movies</h1>
</div>

<x-sorting-and-search-bar 
    :sortOptions="[ 
        'popularity_desc' => 'Rating (Descending)', 
        'popularity_asc' => 'Rating (Ascending)', 
        'release_date_asc' => 'Release Date (Oldest)', 
        'release_date_desc' => 'Release Date (Newest)', 
        'title_asc' => 'Title (A-Z)', 
        'title_desc' => 'Title (Z-A)' 
    ]" 
    :sort="$sort"   
    placeholder="Search Popular Movies by Title..." 
    :searchRoute="route('search')" />

@foreach ($movies as $movie)
    @include('components.movie-card', [
        'id' => $movie->id,
        'poster_url' => $movie->poster_url,
        'title' => $movie->title,
        'release_date' => $movie->release_date,
        'categories' => $movie->categories, 
        'duration' => $movie->duration,
        'rating' => $movie->rating,
        'overview' => Str::limit($movie->overview, 500, '...'),
        'is_favorite' => $movie->is_favorite,
        'type' => 'movie' 

    ])
@endforeach

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <!-- Showing results text -->
    <div class="text-muted d-none d-sm-block">
        Showing {{ $movies->firstItem() }} to {{ $movies->lastItem() }} of {{ $movies->total() }} results
    </div>

    <!-- Pagination section -->
    <nav aria-label="Movies Pagination" class="w-100">
        <div class="d-flex justify-content-end w-100">
            <div class="pagination-container">
                {{ $movies->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </nav>
</div>
@endsection
