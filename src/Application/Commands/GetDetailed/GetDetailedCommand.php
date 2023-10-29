<?php

namespace Movie\Application\Commands\GetDetailed;

use Movie\Domain\Entity\Movie;
use Movie\Domain\Repository\MovieRepositoryInterface;

final class GetDetailedCommand
{
    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    public function __invoke(GetDetailedDTO $getDetailedDTO): Movie
    {
        return $this->movieRepository->getDetails(
            $this->movieRepository->getById($getDetailedDTO->id)
        );
    }
}
