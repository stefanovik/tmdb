<?php

namespace Movie\Application\Commands\GetNewReleases;

use Movie\Domain\Repository\MovieRepositoryInterface;

class GetNewReleasesCommand
{
    public function __construct(public readonly MovieRepositoryInterface $movieRepository)
    {
    }

    public function __invoke(GetNewReleasesDTO $getNewReleasesDTO): void
    {
        $this->movieRepository->getNewReleases($getNewReleasesDTO->date);
    }
}
