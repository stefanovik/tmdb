<?php

namespace Movie\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Movie\Domain\Repository\GenreRepositoryInterface;
use Movie\Domain\Repository\MovieRepositoryInterface;
use Movie\Infrastructure\API\APIGenreRepository;
use Movie\Infrastructure\API\APIMovieRepository;
use Movie\Infrastructure\Database\DbGenreRepository;
use Movie\Infrastructure\Database\DbMovieRepository;

class RepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GenreRepositoryInterface::class, APIGenreRepository::class);
        $this->app->extend(
            GenreRepositoryInterface::class,
            fn (GenreRepositoryInterface $previous): GenreRepositoryInterface => new DbGenreRepository($previous)
        );

        $this->app->bind(MovieRepositoryInterface::class, APIMovieRepository::class);
        $this->app->extend(
            MovieRepositoryInterface::class,
            fn (MovieRepositoryInterface $previous): MovieRepositoryInterface => new DbMovieRepository(
                $previous,
                $this->app->get(GenreRepositoryInterface::class)
            )
        );
    }
}
