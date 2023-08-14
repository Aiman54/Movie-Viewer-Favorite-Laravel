<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $apiKey = 'df3399844df0ad047c8e20af5b22ddcc';
        $totalPages = 2; // Number of pages to fetch (adjust as needed)

        $movies = [];

        for ($page = 1; $page <= $totalPages; $page++) {
            $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
                'api_key' => $apiKey,
                'sort_by' => 'popularity.desc',
                'page' => $page,
            ]);

            $movies = array_merge($movies, $response->json()['results']);
        }

        return view('movies', ['movies' => $movies]);
    }
}
