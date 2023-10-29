<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\Helper\MovieProvider;

uses(RefreshDatabase::class);

it('tests that with no movies we return an empty array', function () {
    $this->getJson('/api/movie/list?page=1&pageSize=1')
        ->assertExactJson([
            'movies' => [],
            'count' => 0
        ]);
});

it('tests that with one movie and one per page for page 1 we return something', function () {
    MovieProvider::addMovie();
    Http::fake([
        'https://api.themoviedb.org/3/genre/movie/list?language=en' => Http::response([
            'genres' => [
                [
                    'id' => 1,
                    'name' => fake()->name,
                ],
                [
                    'id' => 2,
                    'name' => fake()->name,
                ],
                [
                    'id' => 4,
                    'name' => fake()->name,
                ],
            ]
        ])
    ]);
    $this->getJson('/api/movie/list?page=1&pageSize=1')
        ->assertJsonCount(1, 'movies')
        ->assertJsonPath('count', 1);
});

it('tests that with one movie and one per page for page 2 we return nothing', function () {
    MovieProvider::addMovie();
    Http::fake([
        'https://api.themoviedb.org/3/genre/movie/list?language=en' => Http::response([
            'genres' => [
                [
                    'id' => 1,
                    'name' => fake()->name,
                ],
                [
                    'id' => 2,
                    'name' => fake()->name,
                ],
                [
                    'id' => 4,
                    'name' => fake()->name,
                ],
            ]
        ])
    ]);
    $this->getJson('/api/movie/list?page=2&pageSize=1')
        ->assertExactJson([
            'movies' => [],
            'count' => 1
        ]);
});

it('tests that with two movies we return OK for both pages', function () {
    MovieProvider::addMovie();
    MovieProvider::addMovie();
    Http::fake([
        'https://api.themoviedb.org/3/genre/movie/list?language=en' => Http::response([
            'genres' => [
                [
                    'id' => 1,
                    'name' => fake()->name,
                ],
                [
                    'id' => 2,
                    'name' => fake()->name,
                ],
                [
                    'id' => 4,
                    'name' => fake()->name,
                ],
            ]
        ])
    ]);
    $this->getJson('/api/movie/list?page=1&pageSize=1')
        ->assertJsonCount(1, 'movies')
        ->assertJsonPath('count', 2);
    $this->getJson('/api/movie/list?page=2&pageSize=1')
        ->assertJsonCount(1, 'movies')
        ->assertJsonPath('count', 2);
});
