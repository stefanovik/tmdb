<?php

namespace App\Http\Docs\Schema;

use Illuminate\Support\Collection;
use Movie\Domain\Entity\Movie;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class MovieListDTO
{
    #[Property(type: 'array', items: new Items(ref: '#/components/schemas/MovieListItemDTO'))]
    public Collection $movies;
    #[Property]
    public int $count;

    public function __construct(Collection $movies, int $count)
    {
        $this->movies = $movies->map(fn (Movie $movie) => new MovieListItemDTO($movie));
        $this->count = $count;
    }
}
