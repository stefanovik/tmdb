<?php

namespace Movie\Infrastructure\API;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Movie\Domain\Entity\Collection\GenreCollection;
use Movie\Domain\Entity\Collection\MovieCollection;
use Movie\Domain\Entity\Movie;
use Movie\Domain\Entity\MovieDetails;
use Movie\Domain\Repository\MovieRepositoryInterface;
use Movie\Infrastructure\Error\NotSupportedError;

class APIMovieRepository implements MovieRepositoryInterface
{
    public function getList(): MovieCollection
    {
        Log::info('Movie list is empty');
        return new MovieCollection();
    }

    public function getNewReleases(CarbonImmutable $releaseDate, int $page = 1): MovieCollection
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('http.tmdb.read_token'),
            'accept' => 'application/json'
        ])->get(config('http.tmdb.new_releases'), [
            'page' => $page,
            'primary_release_date.gte' => $releaseDate->format('Y-m-d'),
            'primary_release_date.lte' => $releaseDate->format('Y-m-d')
        ])->json();

        $movieCollection = new MovieCollection(collect($response['results'])->map(fn (array $item) => new Movie(
            $item['original_title'],
            new GenreCollection($item['genre_ids']),
            new CarbonImmutable($item['release_date']),
            id: $item['id']
        )));

        if ($response['total_pages'] > $page) {
            return $movieCollection->merge($this->getNewReleases($releaseDate, ++$page));
        }

        return $movieCollection;
    }

    public function getDetails(Movie $movie): Movie
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('http.tmdb.read_token'),
            'accept' => 'application/json'
        ])->get(config('http.tmdb.details') . $movie->id)->json();

        return new Movie(
            $movie->title,
            $movie->genres,
            $movie->primaryReleaseDate,
            new MovieDetails(
                $response['original_title'],
                $response['overview'],
                $response['popularity'],
                $response['vote_average'],
                $response['vote_count'],
                $response['status'],
                $response['poster_path'] ?? '',
                $response['original_language']
            ),
            $movie->id
        );
    }

    /**
     * @throws NotSupportedError
     */
    public function getById(int $id): Movie
    {
        Log::error('Not supported capability');
        throw new NotSupportedError();
    }
}
