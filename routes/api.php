<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::apiResource('books', BookController::class);


Route::get('/message', function () {
    return response()->json(['message' => 'Hewwo uwu']);
});
