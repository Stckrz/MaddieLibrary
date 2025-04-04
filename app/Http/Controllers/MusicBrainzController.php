<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MusicBrainzController extends Controller
{
    //This gets albums by artist name.. Not my favorite, but it'll work for now..
    public function getAlbumsByQuery(Request $request)
    {
        $search = $request->query('query');
        $url = "https://musicbrainz.org/ws/2/release-group/";
        $queryParam = 'primarytype:album AND artist:"' . $search . '"';

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)',
            'Accept' => 'application/json'
        ])->get($url, [
            'query' => $queryParam,
            'limit' => 100,
            'fmt' => 'json',
        ]);
        return response()->json($response->json());
    }
}
