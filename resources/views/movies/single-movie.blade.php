@extends('layouts.app')
@section('title', $movie->title)

@section('content')
<div class="text-center mt-5 position-relative">
    <h1 class="mb-3">This is the Movie you were searching for:</h1>
</div>
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

@endsection
