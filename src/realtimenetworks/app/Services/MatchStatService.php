<?php

namespace App\Services;

use App\Models\MatchModel;
use App\Models\MatchParameters;
use App\Models\Player;
use App\Repositories\MatchStats\MatchStatRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Support\Facades\DB;

class MatchStatService implements MatchStatServiceInterface
{
    public function browse(array $params = [])
    {
        $limit = $params['limit'] ?? 25;
        $year = $params['year'] ?? date('Y');
        $parameterId = $params['param_id'];
        $page = $params['page'] ?? 1;
        $start = "{$year}-01-01";
        $end = "{$year}-12-31";


        /*
         * Grab the cached lists
         */
        $playersList = $this->Player->cached()
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['football_name']];
            })->toArray();
        $matchesList = $this->Match->cached()
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['match_at']];
            })->toArray();
        $parametersList = $this->Parameters->cached()
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            })->toArray();


        /*
         * Work with the cached list.
         * Execution time is quicker
         * than incorportaing this in
         * one big SQL.
         */
        $matchesId = $this->Match->cached()->reject(function ($match) use ($start, $end) {
            $start = Carbon::createFromFormat('Y-m-d', $start)->startOf('day');
            $end = Carbon::createFromFormat('Y-m-d', $end)->endOf('day');
            return !$match->match_at->between($start, $end);
        })->pluck('id')->toArray();

        /*
         * Pass all necessary data to the final
         * SQL to generate the list.
         * This query is hitting 2 birds with one stone,
         * In one query we are able to determine both the
         * total number of rows and at the same time being
         * the result already.
         *
         * Normally, Eloquent's paginate() method runs the same
         * query (in this case with SUM()) twice - to get total
         * and the results. It is hardware intensive when SUM()
         * is included just to get to total count.
         */
        $items = $this->repository->overviewPlayerHighestScores(
            $matchesId,
            $parameterId,
            $playersList,
            $parametersList,
            $matchesList
        );

        /*
         * Generate a pagination-specific
         * format data
         */
        return new LengthAwarePaginator(
            $items->splice(($page - 1) * $limit, $limit),
            count($items),
            $limit,
            $page
        );
    }

    public function __construct(
        protected MatchStatRepository $repository,
        private Player                $Player,
        private MatchModel            $Match,
        private MatchParameters       $Parameters
    )
    {
    }
}
