<?php

return [
    'tmdb' => [
        'api_key' => env('TMDB_API_KEY', ''),
        'read_token' => env('TMDB_READ_TOKEN', ''),
        'new_releases' => 'https://api.themoviedb.org/3/discover/movie',
        'details' => 'https://api.themoviedb.org/3/movie/',
        'genres' => 'https://api.themoviedb.org/3/genre/movie/list?language=en'
    ]
];
