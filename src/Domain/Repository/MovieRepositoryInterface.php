<?php

namespace Movie\Domain\Repository;

use Carbon\CarbonImmutable;
use Movie\Domain\Entity\Collection\MovieCollection;
use Movie\Domain\Entity\Movie;

interface MovieRepositoryInterface
{
    public function getList(): MovieCollection;
    public function getNewReleases(CarbonImmutable $releaseDate): MovieCollection;
    public function getDetails(Movie $movie): Movie;
    public function getById(int $id): Movie;
}
