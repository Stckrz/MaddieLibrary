<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CdController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GiantBombController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UnifiedDistributableController;

use App\Http\Controllers\PatronController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\TmdbController;

Route::apiResource('distributables', UnifiedDistributableController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('cds', CdController::class);
Route::apiResource('movies', MovieController::class);
Route::apiResource('shows', ShowController::class);
Route::apiResource('patrons', PatronController::class);

Route::post('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/checkin/{id}', [CheckoutController::class, 'checkIn']);
Route::get('/checkouts', [CheckoutController::class, 'index']);

Route::get('/searchGames', [GiantBombController::class, 'getGamesByQuery']);

Route::get('/searchMovies', [TmdbController::class, 'getMoviesByQuery']);
Route::get('/searchShows', [TmdbController::class, 'getShowsByQuery']);

Route::get('/searchAlbums', [SpotifyController::class, 'getAlbumsByQuery']);



Route::get('/message', function () {
    return response()->json(['message' => 'Hewwo uwu']);
});
