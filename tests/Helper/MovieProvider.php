<?php

namespace Tests\Helper;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class MovieProvider
{
    private static int $id = 1;
    public static function addMovie(): int
    {
        $id = self::$id;
        DB::table('movies')->upsert(
            [
                'id' => self::$id++,
                'title' => fake()->title,
                'genre_ids' => json_encode([1]),
                'release_date' => CarbonImmutable::now()->format('Y-m-d')
            ],
            'id'
        );

        return $id;
    }
}
