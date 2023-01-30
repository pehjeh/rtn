<?php

namespace App\Repositories\MatchStats;

use App\Models\MatchStat;
use App\Repositories\BaseRepository;
use App\Repositories\Traits\PaginationTrait;

class MatchStatRepository extends BaseRepository
{
    use PaginationTrait, OverviewTrait;

    public function model(): string
    {
        return MatchStat::class;
    }

    public function byMatchYear($year)
    {
        $this->model = $this->model->whereHas('match', function ($query) use ($year) {
            $start = "{$year}-01-01";
            $end = "{$year}-12-31";
            $query->whereBetween('match_at', [$start, $end]);
        });
        return $this;
    }
}
