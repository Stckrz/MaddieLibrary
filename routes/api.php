<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PatronController;

Route::apiResource('books', BookController::class);
Route::apiResource('patrons', PatronController::class);


Route::get('/message', function () {
    return response()->json(['message' => 'Hewwo uwu']);
});
