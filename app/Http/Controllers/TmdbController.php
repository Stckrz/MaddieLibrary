<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TmdbController extends Controller
{
    public function getMoviesByQuery(Request $request)
    {
        $queryString = $request->query('query');
        $url = "https://api.themoviedb.org/3/search/movie?query={$queryString}&include_adult=false&language=en-US&page=1";

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.tmdb.key'),
        ])->get($url);

        return response()->json($response->json());
    }

    public function getShowsByQuery(Request $request)
    {
        $queryString = $request->query('query');
        $url = "https://api.themoviedb.org/3/search/tv?query={$queryString}&include_adult=false&language=en-US&page=1";

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.tmdb.key'),
        ])->get($url);

        return response()->json($response->json());
    }
}

