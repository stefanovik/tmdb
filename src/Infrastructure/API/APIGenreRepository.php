<?php

namespace Movie\Infrastructure\API;

use Illuminate\Support\Facades\Http;
use Movie\Domain\Entity\Collection\GenreCollection;
use Movie\Domain\Entity\Genre;
use Movie\Domain\Repository\GenreRepositoryInterface;

class APIGenreRepository implements GenreRepositoryInterface
{
    public function getAll(): GenreCollection
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('http.tmdb.read_token'),
            'accept' => 'application/json'
        ])->get(config('http.tmdb.genres'))->json()['genres'];

        return new GenreCollection(
            collect($response)->map(fn (array $item) => new Genre($item['id'], $item['name']))
        );
    }

    public function getById(int $id): Genre
    {
        return $this->getAll()->first(fn (Genre $genre) => $genre->id === $id);
    }
}
