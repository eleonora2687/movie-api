<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TVShowController;
use App\Http\Controllers\SearchController;

Route::post('/movies/toggle-favorite', [MovieController::class, 'toggleFavorite'])->name('movies.toggle-favorite');
Route::get('/movies/popular-movies', [MovieController::class, 'popularMovies'])->name('popular-movies');
Route::get('/movies/upcoming-movies', [MovieController::class, 'upcomingMovies'])->name('upcoming-movies');
Route::get('/movies/top-rated-movies', [MovieController::class, 'topRatedMovies'])->name('top-rated-movies');

Route::get('/', function () {
    return view('welcome'); 
})->name('home');  

Route::get('/favorites/all', [MovieController::class, 'allFavorites'])->name('favorites.all-favorite');
Route::get('/movies/popular/{id}', [MovieController::class, 'showPopularMovie'])->name('movies.popular.show');
Route::get('/movies/upcoming/{id}', [MovieController::class, 'showUpcomingMovie'])->name('movies.upcoming.show');
Route::get('/movies/top-rated/{id}', [MovieController::class, 'showTopRatedMovie'])->name('movies.topRated.show');

Route::get('/tv-shows/popular-tv-shows', [TVShowController::class, 'popularTVShows'])->name('popular-tv-shows');
Route::get('/tv-shows/popular/{id}', [TVShowController::class, 'showPopularTVShow'])->name('tv-shows.popular.show');

Route::get('/tv-shows/on-the-air-tv-shows', [TVShowController::class, 'onTheAirTVShows'])->name('on-the-air-tv-shows');
Route::get('/tv-shows/on-the_air/{id}', [TVShowController::class, 'showOnTheAirTVShow'])->name('tv-shows.on-the-air.show');

Route::get('/tv-shows/top-rated-tv-shows', [TVShowController::class, 'topRatedTVShows'])->name('top-rated-tv-shows');
Route::get('/tv-shows/top-rated/{id}', [TVShowController::class, 'showTopRatedTVShow'])->name('tv-shows.top-rated.show');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/movies/all-movies', [MovieController::class, 'allMovies'])->name('all-movies');
Route::get('/movies/all-movies/{id}', [MovieController::class, 'showAllMovie'])->name('movies.all.show');

Route::get('/tv-shows/all-tv-shows', [TVShowController::class, 'allTVShows'])->name('all-tv-shows');
Route::get('/tv-shows/all-tv-shows/{id}', [TVShowController::class, 'showAllTVShow'])->name('tv-shows.all.show');
