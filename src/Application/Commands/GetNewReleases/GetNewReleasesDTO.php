<?php

namespace Movie\Application\Commands\GetNewReleases;

use Carbon\CarbonImmutable;

class GetNewReleasesDTO
{
    public function __construct(public readonly CarbonImmutable $date)
    {
    }
}
