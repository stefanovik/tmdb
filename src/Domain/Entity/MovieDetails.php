<?php

namespace Movie\Domain\Entity;

class MovieDetails
{
    public function __construct(
        public readonly string $name,
        public readonly string $overview,
        public readonly float $popularity,
        public readonly float $voteAverage,
        public readonly float $voteCount,
        public readonly string $status,
        public readonly string $poster,
        public readonly string $language
    ) {
    }
}
