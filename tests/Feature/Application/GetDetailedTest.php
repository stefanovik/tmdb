<?php

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\Helper\MovieProvider;

uses(RefreshDatabase::class);

it('tests that detailed returned successfully', function() {
    $id = MovieProvider::addMovie();
    Http::fake([
        'https://api.themoviedb.org/3/genre/movie/list?language=en' => Http::response([
            'genres' => [
                [
                    'id' => 1,
                    'name' => "Drama",
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
    Http::fake([
        'https://api.themoviedb.org/3/movie/' . $id => Http::response(
            [
                "adult" => false,
                "backdrop_path" => "/dzm6sNpz9UwG208xyGKAJ6e4ybA.jpg",
                "belongs_to_collection" => null,
                "budget" => 0,
                "genres" => [
                    [
                        "id" => 18,
                        "name" => "Drama"
                    ]
                ],
                "homepage" => "",
                "id" => 166666,
                "imdb_id" => "tt1667355",
                "original_language" => "de",
                "original_title" => "3096 Tage",
                "overview" => "A young Austrian girl is kidnapped and held in captivity for eight years. Based on the real-life case of Natascha Kampusch.",
                "popularity" => 27.734,
                "poster_path" => "/jQ7aucozEWiz1cBCdZtcYSJfWC7.jpg",
                "production_companies" => [
                    [
                        "id" => 47,
                        "logo_path" => "/i7Z9ot2o3N5Sa3HrF09kniFs2y8.png",
                        "name" => "Constantin Film",
                        "origin_country" => "DE"
                    ],
                    [
                        "id" => 45198,
                        "logo_path" => "/9z46Z8Px88a30wkr7G0QUDbbtt2.png",
                        "name" => "Deutscher Filmförderfonds",
                        "origin_country" => "DE"
                    ],
                    [
                        "id" => 6187,
                        "logo_path" => "/gtC63XG8fkFxszIuZIogffM1oY8.png",
                        "name" => "ARD Degeto",
                        "origin_country" => "DE"
                    ],
                    [
                        "id" => 7201,
                        "logo_path" => "/ljV8ZT3CIYCEIEDlTyBliXJVCZr.png",
                        "name" => "NDR",
                        "origin_country" => "DE"
                    ],
                    [
                        "id" => 268,
                        "logo_path" => "/vxMEWcZ4TZ5XaK3fMVM4PRjvUDv.png",
                        "name" => "FFF Bayern",
                        "origin_country" => "DE"
                    ],
                    [
                        "id" => 2026,
                        "logo_path" => "/q9s9KGhSsFEnpTmLLwprytB3T3d.png",
                        "name" => "FFA",
                        "origin_country" => "DE"
                    ],
                    [
                        "id" => 162,
                        "logo_path" => "/pIK5tsFVxjoXTJGcd0nYhiL1kn1.png",
                        "name" => "BR",
                        "origin_country" => "DE"
                    ]
                ],
                "production_countries" => [
                    [
                        "iso_3166_1" => "DE",
                        "name" => "Germany"
                    ]
                ],
                "release_date" => "2013-02-21",
                "revenue" => 6677474,
                "runtime" => 111,
                "spoken_languages" => [
                    [
                        "english_name" => "English",
                        "iso_639_1" => "en",
                        "name" => "English"
                    ]
                ],
                "status" => "Released",
                "tagline" => "The story of Natasha Kampusch",
                "title" => "3096 Days",
                "video" => false,
                "vote_average" => 7.444,
                "vote_count" => 811
            ]
        )
    ]);
    $this->getJson('/api/movie/' . $id)
        ->assertExactJson([
            'name' => '3096 Tage',
            'overview' => 'A young Austrian girl is kidnapped and held in captivity for eight years. Based on the real-life case of Natascha Kampusch.',
            "popularity" => 27.734,
            'voteAverage' => 7.444,
            'voteCount' => 811,
            'status' => 'Released',
            'poster' => '/jQ7aucozEWiz1cBCdZtcYSJfWC7.jpg',
            'genres' => 'Drama',
            'language' => 'de'
        ]);
});
