<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GiantBombController extends Controller
{
    public function getGamesByQuery(Request $request)
    {
        $queryString = $request->query('query');
        $url = 'https://www.giantbomb.com/api/search/';

        $response = Http::get($url, [
            'api_key' => config('services.giantBomb.key'),
            'query' => $queryString,
            'resources' => 'game',
            'format' => 'json',
        ]);

        return response()->json($response->json());
    }
}
