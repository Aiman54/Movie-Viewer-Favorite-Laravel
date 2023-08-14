<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $movieId = $request->input('movie_id');
    
            // Check if the user has already favorited the movie
            $favorite = Favorite::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->first();
    
            if ($favorite) {
                // The movie is already favorited by the user
                return response()->json(['message' => 'Movie already favorited']);
            }
    
            // Save the favorite record to the favorites table
            $newFavorite = new Favorite([
                'user_id' => $user->id,
                'movie_id' => $movieId,
            ]);
            $newFavorite->save();
    
            return response()->json(['message' => 'Movie added to favorites']);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function checkFavorite(Request $request, $movieId)
    {
        $isFavorite = false;

        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $favorite = Favorite::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->first();

            if ($favorite) {
                $isFavorite = true;
            }
        } else {
            // Check if the movie is stored as a favorite in a session or cookie
            $favoriteMovies = $request->session()->get('favorite_movies', []);
            if (in_array($movieId, $favoriteMovies)) {
                $isFavorite = true;
            }
        }

        return response()->json(['is_favorite' => $isFavorite]);
    }

    public function favoredMovies()
    {
        $user = auth()->user(); // Assuming you're using authentication

        $favoredMovies = Favorite::where('user_id', $user->id)
            ->with('movie') // Assuming you have a relationship between Favorite and Movie models
            ->paginate(10);

        return view('favored-movies', ['favoredMovies' => $favoredMovies]);
    }

    public function favoredMovieTitles()
    {
        if (auth()->check()) {
            $user = auth()->user();
    
            $favoredMovies = Favorite::where('user_id', $user->id)
                ->with('movie') // Assuming you have a relationship between Favorite and Movie models
                ->get();
            
            $favoredMovies = Favorite::where('user_id', $user->id)
            ->with('movie') // Assuming you have a relationship between Favorite and Movie models
            ->paginate(10);
    
            return view('favored-movies', ['favoredMovies' => $favoredMovies]);
        } else {
            // Handle the case where the user is not authenticated
            return redirect()->route('login'); // Or any other logic you prefer
        }
    
    }

    public function removeFavorite(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $movieId = $request->input('movie_id');

            // Find and delete the favorite record for the movie
            Favorite::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->delete();

            return response()->json(['message' => 'Movie removed from favorites']);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

}
