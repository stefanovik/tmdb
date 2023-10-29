<?php

namespace Movie\Application\Commands\GetDetailed;

final class GetDetailedDTO
{
    public function __construct(public readonly int $id)
    {
    }
}
