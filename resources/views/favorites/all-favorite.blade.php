@extends('layouts.app')

@section('title', 'Favorites')

@section('content')
<div class="text-center mt-5 position-relative">
    <h1 class="mb-3">Favorites</h1>
</div>

@foreach($favorites as $favorite)
    @if ($favorite instanceof App\Models\Movie)
    @include('components.movie-card', [
        'poster_url' => $favorite->poster_url,
        'title' => $favorite->title,
        'release_date' => $favorite->release_date,
        'categories' => $favorite->categories,
        'duration' => $favorite->duration ?? null, 
        'rating' => $favorite->rating,
        'overview' => $favorite->overview,
        'is_favorite' => $favorite->is_favorite,
        'id' => $favorite->id,
        'type' => $favorite instanceof App\Models\Movie ? 'movie' : 'tvshow'

    ])

    @elseif ($favorite instanceof App\Models\TVShow)
    @include('components.movie-card', [
        'poster_url' => $favorite->poster_url,
        'title' => $favorite->title,
        'release_date' => $favorite->release_date,
        'categories' => $favorite->categories,
        'duration' => $favorite->duration ?? null, 
        'rating' => $favorite->rating,
        'overview' => $favorite->overview,
        'is_favorite' => $favorite->is_favorite,
        'id' => $favorite->id,
        'type' => $favorite instanceof App\Models\TVShow ? 'tvshow' : 'movie'
    ])

    @endif

@endforeach

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <!-- Results Information -->
    <div class="text-muted">
        Showing {{ $favorites->firstItem() }} to {{ $favorites->lastItem() }} of {{ $favorites->total() }} results
    </div>

    <!-- Pagination Links -->
    <nav aria-label="Favorites Pagination">
        {{ $favorites->links('pagination::bootstrap-4') }} 
    </nav>
</div>

@endsection