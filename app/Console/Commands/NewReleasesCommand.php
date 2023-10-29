<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Movie\Application\Commands\GetNewReleases\GetNewReleasesCommand;
use Movie\Application\Commands\GetNewReleases\GetNewReleasesDTO;

class NewReleasesCommand extends Command
{
    protected $signature = 'tmdb:recent-releases';
    protected $description = 'Fetches all new releases from tmdb';

    public function handle(GetNewReleasesCommand $handler): void
    {
        $handler(new GetNewReleasesDTO(new CarbonImmutable()));
    }
}
