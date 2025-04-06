<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Exception;
use Carbon\Carbon;

class SpotifyOAuthService
{
    protected $clientId;
    protected $clientSecret;
    protected $tokenUrl;
    protected $cacheKey = 'spotify_access_token';

    //This is a buffer to renew token BEFORE it expires
    protected $bufferseconds = 60;

    public function __construct()
    {
        $this->clientId = config('services.spotify_oauth.client_id');
        $this->clientSecret = config('services.spotify_oauth.client_secret');
        $this->tokenUrl = config('services.spotify_oauth.token_url');
    }

    //this gets the valid api token from the cache, OR creates a new one
    public function getAccessToken()
    {
        if (Cache::has($this->cacheKey)) {
            $data = Cache::get($this->cacheKey);
            if (Carbon::now()->lt(Carbon::parse($data['expires_at']))) {
                return $data['access_token'];
            }
        }
        return $this->refreshAccessToken();
    }

    //this refreshes the access token by calling the auth api
    public function refreshAccessToken()
    {

        $response = Http::asForm()->post($this->tokenUrl, [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);
        if ($response->failed()) {
            throw new Exception('Unable to obtain access token');
        }

        $tokendata = $response->json();

        if (!isset($tokendata['access_token'], $tokendata['token_type'], $tokendata['expires_in'])) {
            throw new Exception('Token response missing expected value');
        }

        //using Carbon to set the expiration time, with a buffer time to be safe
        $expiresAt = Carbon::now()->addSeconds($tokendata['expires_in'] - $this->bufferseconds);

        //cache token data
        Cache::put($this->cacheKey, [
            'access_token' => $tokendata['access_token'],
            'expires_at'   => $expiresAt->toDateTimeString(),
        ], $tokendata['expires_in']);

        return $tokendata['access_token'];
    }

    //makes an api call using the access token
    public function makeApiRequest($endpoint, $method = 'GET', $data = [])
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)->$method($endpoint, $data);

        // If the API responds with 401, try refreshing the token.
        if ($response->status() === 401) {
            $token = $this->refreshAccessToken();
            $response = Http::withToken($token)->$method($endpoint, $data);
        }

        return $response->json();
    }
}
