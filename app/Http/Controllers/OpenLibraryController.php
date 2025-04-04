<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OpenLibraryController extends Controller
{
    public function getBooksByQuery(Request $request)
    {
        $queryString = $request->query('query');
        $url = 'https://openlibrary.org/search.json';

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)'
        ])->get($url, [
            'q' => $queryString,
            'limit' => 10,
        ]);
        return response()->json($response->json());
    }

    public function getBookByKey(Request $request)
    {
        $queryString = $request->query('key');
        $url = "https://openlibrary.org/{$queryString}.json";

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)'
        ])->get($url);
        return response()->json($response->json());
    }

    public function getCoverByOlid(Request $request)
    {
        $olid = $request->query('olid');
        $url = "https://covers.openlibrary.org/a/olid/{$olid}-M.jpg";

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)'
        ])->head($url);

        if ($response->ok()) {
            return response()->json(['url' => $url]);
        } else {
            return response()->json(['error' => 'Cover not found'], 404);
        }
    }
}
