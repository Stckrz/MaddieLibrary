<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Services\SpotifyOAuthService;

class SpotifyController extends Controller
{
    protected $spotifyOAuthService;
    public function __construct(SpotifyOAuthService $spotifyOAuthService)
    {
        $this->spotifyOAuthService = $spotifyOAuthService;
    }

    public function getAlbumsByQuery(Request $request)
    {
        $search = $request->query('query');
        $url = "https://api.spotify.com/v1/search?q={$search}&type=album";

        // Get a valid access token from our OAuth service
        $accessToken = $this->spotifyOAuthService->getAccessToken();

        $response = Http::withHeaders([
            'User-Agent' => 'StckrzLibraryApp/1.0 (contact: rin449@gmail.com)',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,

        ])->get($url);
        return response()->json($response->json());
    }
}
