<?php

namespace App\Repositories\MatchStats;

use Illuminate\Support\Facades\DB;

trait OverviewTrait
{
    public function overviewPlayerHighestScores(
        $matchesId,
        $parameterId,
        $playersList,
        $parametersList,
        $matchesList
    )
    {
        $query = DB::table('match_stats AS ms')
            ->selectRaw('SUM(ms.value) As score, ms.player_id, ms.param_id, ms.match_id')
            ->whereIn('ms.match_id', $matchesId)
            ->whereNotNull('ms.player_id')
            ->whereNotNull('ms.param_id')
            ->whereNotNull('ms.team_id')
            ->whereNotNull('ms.match_id')
            ->groupBy('ms.player_id')
            ->orderBy('score', 'DESC');

        if ($parameterId) {
            $query = $query->where('ms.param_id', $parameterId);
        }

        return $query
            ->get()
            ->map(function ($row) use ($playersList, $parametersList, $matchesList) {
                return [
                    'score' => $row->score,
                    'football_name' => $playersList[$row->player_id],
                    'parameter_name' => $parametersList[$row->param_id],
                    'match_at' => $matchesList[$row->match_id],
                ];
            });
    }
}
