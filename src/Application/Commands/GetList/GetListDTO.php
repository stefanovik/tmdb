<?php

namespace Movie\Application\Commands\GetList;

class GetListDTO
{
    public function __construct(public readonly int $page, public readonly int $pageSize)
    {
    }
}
