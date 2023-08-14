<!DOCTYPE html>
<html>
<head>
    <title>Movie List</title>
    <!-- Include the Axios library -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>

        
        /* Reset some default styles */
        body, ul {
            margin: 0;
            padding: 0;
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

        .favorite-button {
            display: inline-block;
            padding: 8px 20px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .favorite-button:hover {
            background-color: #d9534f;
        }

        h1 {
            text-align: center;
            margin: 30px 0; /* Adjust vertical spacing as needed */
        }

    </style>

</head>
<body>

<!-- Header section with links -->
<header>
    <nav>
        <ul>
            <li><a href="/movies">Popular Movies</a></li>
            <li><a href="/favored-movie">Favored Movies</a></li>
        </ul>
    </nav>
</header>

<h1>Popular Movies</h1>

<!-- Movie list -->
<div class="movie-list">
    @foreach ($movies as $movie)
        <div class="movie-card">
            <h2>{{ $movie['title'] }}</h2>
            <p><strong>Release Date:</strong> {{ $movie['release_date'] }}</p>
            <p><strong>Overview:</strong> {{ $movie['overview'] }}</p>
            <p><strong>Popularity:</strong> {{ $movie['popularity'] }}</p>
            <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }} Poster">
            <button class="favorite-button" data-movie-id="{{ $movie['id'] }}">Favorite</button>
        </div>
    @endforeach
</div>

<!-- Your JavaScript code -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const favoriteButtons = document.querySelectorAll('.favorite-button');

        favoriteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const movieId = button.getAttribute('data-movie-id');

                axios.post('/favorite', { movie_id: movieId })
                    .then(response => {
                        alert(response.data.message); // Display success message
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
