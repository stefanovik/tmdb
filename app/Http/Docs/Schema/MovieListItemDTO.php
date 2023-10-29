<?php

namespace App\Http\Docs\Schema;

use Movie\Domain\Entity\Genre;
use Movie\Domain\Entity\Movie;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class MovieListItemDTO
{
    #[Property]
    public int $id;
    #[Property]
    public string $title;
    #[Property]
    public string $genres;
    #[Property]
    public string $releaseDate;

    public function __construct(Movie $movie)
    {
        $this->id = $movie->id;
        $this->title = $movie->title;
        $this->genres = $movie->genres->map(fn (Genre $genre) => $genre->name)->join(', ');
        $this->releaseDate = $movie->primaryReleaseDate->format('Y-m-d');
    }
}
