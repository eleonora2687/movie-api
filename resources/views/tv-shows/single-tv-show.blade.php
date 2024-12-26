@extends('layouts.app')
@section('title', $tvshow->title)

@section('content')
<div class="text-center mt-5 position-relative">
    <h1 class="mb-3">This is the TV Show you were searching for:</h1>
</div>
@include('components.movie-card', [
        'id' => $tvshow->id,
        'poster_url' => $tvshow->poster_url,
        'title' => $tvshow->title,
        'release_date' => $tvshow->release_date,
        'categories' => $tvshow->categories, 
        'rating' => $tvshow->rating,
        'overview' => Str::limit($tvshow->overview, 500, '...'),
        'is_favorite' => $tvshow->is_favorite,
        'type' => 'tvshow',

    ])
@endsection
