<?php

namespace Tests\Helper;

use Illuminate\Support\Facades\DB;

class GenreProvider
{
    public static function addGenre(int $id): void
    {
        DB::table('genres')->upsert(
            [
                'id' => $id,
                'name' => fake()->name
            ],
            'id'
        );
    }
}
