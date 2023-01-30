<?php

namespace App\Repositories\MatchParameter;

use App\Models\MatchParameters;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class MatchParameterRepository extends BaseRepository implements RepositoryInterface
{
//    use CacheTrait;

    public function model(): string
    {
        return MatchParameters::class;
    }
}
