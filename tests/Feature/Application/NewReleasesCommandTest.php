<?php

use App\Console\Commands\NewReleasesCommand;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\Helper\GenreProvider;

uses(RefreshDatabase::class);

it('tests that for empty response database is empty', function () {
    $date = CarbonImmutable::now();
    Http::fake([
        'https://api.themoviedb.org/3/discover/movie?page=1&primary_release_date.gte=' . $date->format(
            'Y-m-d'
        ) . '&primary_release_date.lte=' . $date->format('Y-m-d') => Http::response([
            'total_pages' => 1,
            'results' => []
        ])
    ]);
    $this->artisan(NewReleasesCommand::class);

    $this->assertDatabaseEmpty('movies');
});

it('tests that it adds data for one page only', function () {
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
            ]
        ])
    ]);
    $date = CarbonImmutable::now();
    Http::fake([
        'https://api.themoviedb.org/3/discover/movie?page=1&primary_release_date.gte=' . $date->format(
            'Y-m-d'
        ) . '&primary_release_date.lte=' . $date->format('Y-m-d') => Http::response([
            'total_pages' => 1,
            'results' => [
                [
                    'id' => 1,
                    'original_title' => fake()->title,
                    'genre_ids' => [1, 2],
                    'release_date' => CarbonImmutable::now()->format('Y-m-d')
                ]
            ]
        ])
    ]);

    $this->artisan(NewReleasesCommand::class);

    $this->assertDatabaseCount('movies', 1);
    $this->assertDatabaseCount('genres', 2);
});

it('tests that it adds data for multiple pages', function () {
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
    $date = CarbonImmutable::now();
    Http::fake([
        'https://api.themoviedb.org/3/discover/movie?page=1&primary_release_date.gte=' . $date->format(
            'Y-m-d'
        ) . '&primary_release_date.lte=' . $date->format('Y-m-d') => Http::response([
            'total_pages' => 2,
            'results' => [
                [
                    'id' => 1,
                    'original_title' => fake()->title,
                    'genre_ids' => [1, 2],
                    'release_date' => CarbonImmutable::now()->format('Y-m-d')
                ]
            ]
        ])
    ]);

    Http::fake([
        'https://api.themoviedb.org/3/discover/movie?page=2&primary_release_date.gte=' . $date->format(
            'Y-m-d'
        ) . '&primary_release_date.lte=' . $date->format('Y-m-d') => Http::response([
            'total_pages' => 2,
            'results' => [
                [
                    'id' => 2,
                    'original_title' => fake()->title,
                    'genre_ids' => [1, 2],
                    'release_date' => CarbonImmutable::now()->format('Y-m-d')
                ],
                [
                    'id' => 3,
                    'original_title' => fake()->title,
                    'genre_ids' => [4],
                    'release_date' => CarbonImmutable::now()->format('Y-m-d')
                ]
            ]
        ])
    ]);

    $this->artisan(NewReleasesCommand::class);

    $this->assertDatabaseCount('movies', 3);
    $this->assertDatabaseCount('genres', 3);
});
