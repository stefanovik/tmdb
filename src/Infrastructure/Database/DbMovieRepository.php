<?php

namespace Movie\Infrastructure\Database;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Movie\Domain\Entity\Collection\GenreCollection;
use Movie\Domain\Entity\Collection\MovieCollection;
use Movie\Domain\Entity\Movie;
use Movie\Domain\Repository\GenreRepositoryInterface;
use Movie\Domain\Repository\MovieRepositoryInterface;

class DbMovieRepository implements MovieRepositoryInterface
{
    public function __construct(
        private readonly MovieRepositoryInterface $movieRepository,
        private readonly GenreRepositoryInterface $genreRepository
    ) {
    }

    private function getGenres(array $genres): GenreCollection
    {
        return (new GenreCollection($genres))->map(fn (int $id) => $this->genreRepository->getById($id));
    }

    private function mapToMovie(mixed $record): Movie
    {
        return new Movie(
            $record->title,
            $this->getGenres(json_decode($record->genre_ids)),
            CarbonImmutable::createFromFormat('Y-m-d', $record->release_date),
            id: $record->id
        );
    }

    public function getList(): MovieCollection
    {
        $movies = DB::table('movies')->select(['id', 'title', 'genre_ids', 'release_date'])->get();

        return new MovieCollection($movies->map(fn (mixed $record) => $this->mapToMovie($record)));
    }

    public function getNewReleases(CarbonImmutable $releaseDate): MovieCollection
    {
        $movies = $this->movieRepository->getNewReleases($releaseDate);

        $movies->each(fn (Movie $movie) => DB::table('movies')->upsert(
            [
                'id' => $movie->id,
                'title' => $movie->title,
                'genre_ids' => $movie->genres->toJson(),
                'release_date' => $movie->primaryReleaseDate
            ],
            'id'
        ));

        return new MovieCollection(
            $movies->map(fn(Movie $movie) => new Movie(
                $movie->title,
                $this->getGenres($movie->genres->toArray()),
                $movie->primaryReleaseDate,
                id: $movie->id
            ))
        );
    }

    public function getDetails(Movie $movie): Movie
    {
        return $this->movieRepository->getDetails($movie);
    }

    public function getById(int $id): Movie
    {
        return $this->mapToMovie(
            DB::table('movies')
                ->select(['id', 'title', 'genre_ids', 'release_date'])
                ->where('id', $id)
                ->first()
        );
    }
}
