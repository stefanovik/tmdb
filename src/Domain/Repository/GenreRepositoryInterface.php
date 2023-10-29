<?php

namespace Movie\Domain\Repository;

use Movie\Domain\Entity\Collection\GenreCollection;
use Movie\Domain\Entity\Genre;

interface GenreRepositoryInterface
{
    public function getAll(): GenreCollection;
    public function getById(int $id): Genre;
}
