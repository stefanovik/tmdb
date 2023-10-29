<?php

namespace Movie\Infrastructure\Database;

use Illuminate\Support\Facades\DB;
use Movie\Domain\Entity\Collection\GenreCollection;
use Movie\Domain\Entity\Genre;
use Movie\Domain\Repository\GenreRepositoryInterface;

class DbGenreRepository implements GenreRepositoryInterface
{
    public function __construct(private readonly GenreRepositoryInterface $genreRepository)
    {
    }

    public function getAll(): GenreCollection
    {
        $genres = $this->genreRepository->getAll();
        $genres->each(fn (Genre $genre) => DB::table('genres')->upsert(
            [
                'id' => $genre->id,
                'name' => $genre->name
            ],
            'id'
        ));

        return $genres;
    }

    public function getById(int $id): Genre
    {
        $genreRaw = DB::table('genres')->select(['id', 'name'])->where('id', $id)->first();
        if ($genreRaw) {
            return new Genre(
                $genreRaw->id,
                $genreRaw->name
            );
        }

        $genreFromApi = $this->genreRepository->getById($id);
        DB::table('genres')->upsert(
            [
                'id' => $genreFromApi->id,
                'name' => $genreFromApi->name
            ],
            'id'
        );

        return $genreFromApi;
    }
}
