<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AuthServiceProvider extends ServiceProvider
{

    public function getSpotifyToken()
    {
        $response_token = Http::withBasicAuth(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'))
        ->asForm()->post(env('SPOTIFY_TOKEN_URL'),
            [
                'grant_type' => 'client_credentials'
            ]);

        return json_decode($response_token);
    }
}
