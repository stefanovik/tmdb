<?php

namespace Movie\Application\Commands\GetList;

use JetBrains\PhpStorm\ArrayShape;
use Movie\Domain\Repository\MovieRepositoryInterface;

class GetListCommand
{
    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    public function __invoke(GetListDTO $listDTO): array
    {
        $movies = $this->movieRepository->getList();

        return [
            'movies' => collect($movies->forPage($listDTO->page, $listDTO->pageSize)),
            'count' => $movies->count()
        ];
    }
}
