<?php

namespace App\Http\Controllers;
use App\Services\SpotifyService;
use App\Services\Helpers\SpotifyHelper;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    protected $spotifyService;
    protected $spotifyHelper;

    public function __construct(SpotifyService $spotifyService, SpotifyHelper $spotifyHelper)
    {
        $this->spotifyService   = $spotifyService;
        $this->spotifyHelper    = $spotifyHelper;
    }

    public function getDiscographyByAuthor(Request $request)
    {
        $token = $this->spotifyHelper->getToken()->access_token;
        echo "<pre>";
            var_dump($this->spotifyService->processApiResponse($request->input('q'), $token));
        echo "</pre>";
    }
}

