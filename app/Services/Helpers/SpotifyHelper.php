<?php

namespace App\Services\Helpers;
use Illuminate\Support\Facades\Http;
use Exception;

class SpotifyHelper
{    
    /**
     * getToken
     * returns a Token based on an http request.
     * @return json
     */
    public function getToken()
    {
        try {
            $response_token = Http::withBasicAuth(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'))
            ->asForm()->post(env('SPOTIFY_TOKEN_URL'),
                [
                    'grant_type' => 'client_credentials'
                ]);
    
            return json_decode($response_token);

        } catch (\Exception $e) {
            throw new Exception(sprintf("ERROR: '%s'", $e->getMessage()));
        }
    }

    /**
     * getArtistDiscography
     * Based on a string param, returns an array with the Artist discography.
     * @param  string $band_name
     * @param  string $token
     * @return string
     */
    public function getApiEndpoint($band_name, $token)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer '. $token])
                ->get(env('SPOTIFY_ARTIST_ENDPOINT')."/".$band_name."/albums");
    
            return json_decode($response);

        } catch (\Exception $e) {
            throw new Exception(sprintf("ERROR: '%s'", $e->getMessage()));
        }
    }

    public function getArtistId($artist, $type = 'artist', $token){

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '. $token])
            ->get('https://api.spotify.com/v1/search', [
                'query'    => $artist,
                'type'      => $type
            ]);   

        return json_decode($response)->artists->items[0]->id;
    }

    public function processAlbum($albums) {
        
        $discography = array();
        foreach($albums->items as $album){

            $discography[] = array(
                "name" => $album->name ,
                "released" => $album->release_date,
                "tracks" => $album->total_tracks,
                "cover" => (isset($album->images[0]) ? $album->images[0] : 'NULL')
            );

        }

        return $discography;
    }
}    