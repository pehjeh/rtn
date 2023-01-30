<?php

namespace App\Repositories\Team;


use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Repositories\Traits\PaginationTrait;

class TeamRepository extends BaseRepository
{
    use PaginationTrait;

    public function model(): string
    {
        return Team::class;
    }
}
