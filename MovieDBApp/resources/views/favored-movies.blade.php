<!DOCTYPE html>
<html>
<head>
    <title>Favored Movie Titles</title>
    <!-- Include the Axios library -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>

        h1 {
            text-align: center;
            margin: 30px 0; /* Adjust vertical spacing as needed */
        }
        /* Style for navigation header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 10px 20px;
            margin: 0;
        }

        header nav ul li a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        header nav ul li a:hover {
            background-color: #0056b3;
        }

        /* Add some padding to the body to offset content under the fixed header */
        body {
            font-family: Arial, sans-serif;
            padding-top: 70px; /* Adjust as needed */
            margin: 0; /* Remove default margin for full-width content */
        }

        /* Movie list styling */
        .movie-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .movie-card {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .movie-card:hover {
            transform: translateY(-5px);
        }

        .movie-card img {
            max-width: 100%;
            height: auto;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: inline-block;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .pagination a:hover {
            background-color: #0056b3;
        }

        /* Style for active page link */
        .pagination .active a {
            background-color: #0056b3;
            color: white;
        }

        .remove-button {
        background-color: #ff6347; /* Red background */
        color: white;
        border: none;
        border-radius: 5px;
        padding: 6px 12px;
        cursor: pointer;
        transition: background-color 0.2s, color 0.2s;
        font-weight: bold;
        font-size: 14px;
        margin-top: 10px;
        display: block;
        width: 35%;
        text-align: center;
        }

        .remove-button:hover {
            background-color: #d9534f; /* Darker red background on hover */
        }

       
            
    </style>

</head>
<body>

<!-- Header section with links -->
<header>
    <nav>
        <ul>
            <li><a href="/movies">Popular Movies</a></li>
            <li><a href="/favored-movies">Favored Movies</a></li>
        </ul>
    </nav>
</header>

<h1>Favored Movie Titles</h1>

<!-- Movie list -->
<div class="movie-list">
    @foreach ($favoredMovies as $favoredMovie)
        @php
            // Make an API call to fetch movie details using $favoredMovie->movie_id
            $apiKey = 'df3399844df0ad047c8e20af5b22ddcc'; // Replace with your actual API key
            $movieDetailsResponse = Http::get("https://api.themoviedb.org/3/movie/{$favoredMovie->movie_id}", [
                'api_key' => $apiKey,
            ]);
            $movieDetails = $movieDetailsResponse->json();
        @endphp

        <div class="movie-card">
            <h2>{{ $movieDetails['title'] }} ({{ $movieDetails['release_date'] }})</h2>
            <p><strong>Overview:</strong> {{ $movieDetails['overview'] }}</p>
            <p><strong>Popularity:</strong> {{ $movieDetails['popularity'] }}</p>
            <img src="https://image.tmdb.org/t/p/w500/{{ $movieDetails['poster_path'] }}" alt="{{ $movieDetails['title'] }} Poster">

            <button class="remove-button" data-movie-id="{{ $favoredMovie->movie_id }}">Remove</button>
        </div>
    @endforeach
</div>

<div class="pagination-container">
    {{ $favoredMovies->links('pagination::bootstrap-5') }}
</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeButtons = document.querySelectorAll('.remove-button');

        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const movieId = button.getAttribute('data-movie-id');

                axios.post('/remove-favorite', { movie_id: movieId })
                    .then(response => {
                        alert(response.data.message); // Display success message
                        window.location.reload(); // Refresh the page after removing
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    });
</script>



</body>
</html>
