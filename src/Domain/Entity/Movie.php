<?php

namespace Movie\Domain\Entity;

use Carbon\CarbonImmutable;
use Movie\Domain\Entity\Collection\GenreCollection;

class Movie
{
    public function __construct(
        public readonly string $title,
        public readonly GenreCollection $genres,
        public readonly CarbonImmutable $primaryReleaseDate,
        public readonly ?MovieDetails $movieDetails = null,
        public readonly ?int $id = null,
    ) {
    }
}
