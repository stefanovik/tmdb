<?php

namespace App\Http\Docs\Schema;

use Movie\Domain\Entity\Genre;
use Movie\Domain\Entity\Movie;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class MovieDTO
{
    #[Property]
    public string $name;
    #[Property]
    public string $overview;
    #[Property]
    public float $popularity;
    #[Property]
    public float $voteAverage;
    #[Property]
    public float $voteCount;
    #[Property]
    public string $status;
    #[Property]
    public string $poster;
    #[Property]
    public string $genres;
    #[Property]
    public string $language;

    public function __construct(Movie $movie)
    {
        $this->name = $movie->movieDetails->name;
        $this->overview = $movie->movieDetails->overview;
        $this->popularity = $movie->movieDetails->popularity;
        $this->voteAverage = $movie->movieDetails->voteAverage;
        $this->voteCount = $movie->movieDetails->voteCount;
        $this->status = $movie->movieDetails->status;
        $this->poster = $movie->movieDetails->poster;
        $this->language = $movie->movieDetails->language;
        $this->genres = $movie->genres->map(fn (Genre $genre) => $genre->name)->join(', ');
    }
}
