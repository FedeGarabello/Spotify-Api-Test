<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Services\Helpers\SpotifyHelper;
use Exception;

class SpotifyService
{    

    private $spotifyHelper;

    public function __construct(SpotifyHelper $spotifyHelper)
    {
        $this->spotifyHelper = $spotifyHelper;
    }

    public function processApiResponse($band_name, $token){
        try {

            $band_id = $this->spotifyHelper->getArtistId($band_name, 'artist' ,$token);
            $discography = $this->spotifyHelper->getApiEndpoint($band_id, $token);

            $processedResponse = $this->spotifyHelper->processAlbum($discography);
            
            return $processedResponse;
            
        } catch (\Exception $e) {
            throw new Exception(sprintf("ERROR: '%s'", $e->getMessage()));
        }
    }

}