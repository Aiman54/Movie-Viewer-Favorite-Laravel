<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/movies', function () {
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

    
});

Route::get('/movies', [MovieController::class, 'index']);

Route::post('/favorite', [FavoriteController::class, 'addFavorite']);

Route::get('/check-favorite/{movieId}', [FavoriteController::class, 'checkFavorite']);

Route::get('/favored-movies', [FavoriteController::class, 'favoredMovies']);

Route::get('/favored-movie', [FavoriteController::class, 'favoredMovieTitles']);

Route::middleware(['auth'])->group(function () {

Route::post('/remove-favorite', [FavoriteController::class, 'removeFavorite']);


    
   
});

Route::name('login')->get('/login', 'Auth\LoginController@showLoginForm');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



