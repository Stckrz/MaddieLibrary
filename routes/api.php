<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CdController;
use App\Http\Controllers\GiantBombController;
use App\Http\Controllers\OpenLibraryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MusicBrainzController;
use App\Http\Controllers\UnifiedDistributableController;

use App\Http\Controllers\PatronController;

Route::apiResource('distributables', UnifiedDistributableController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('cds', CdController::class);
Route::apiResource('movies', MovieController::class);
Route::apiResource('patrons', PatronController::class);

Route::get('/searchGames', [GiantBombController::class, 'getGamesByQuery']);
Route::get('/searchBooks', [OpenLibraryController::class, 'getBooksByQuery']);
Route::get('/searchBookDetail', [OpenLibraryController::class, 'getBookByKey']);
Route::get('/searchCover', [OpenLibraryController::class, 'getCoverByOlid']);
Route::get('/searchAlbums', [MusicBrainzController::class, 'getAlbumsByQuery']);



Route::get('/message', function () {
    return response()->json(['message' => 'Hewwo uwu']);
});
