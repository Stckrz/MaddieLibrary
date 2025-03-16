<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CdController;
use App\Http\Controllers\UnifiedDistributableController;

use App\Http\Controllers\PatronController;

Route::apiResource('distributables', UnifiedDistributableController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('cds', CdController::class);
Route::apiResource('patrons', PatronController::class);



Route::get('/message', function () {
    return response()->json(['message' => 'Hewwo uwu']);
});
