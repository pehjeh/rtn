<?php

namespace Database\Seeders;

use App\Models\MatchModel;
use App\Models\MatchParameters;
use App\Models\MatchStat;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class MatchStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public array $parameters = [];

    public function run()
    {
        //match_id;team_id;player_id;param_id;param_name;value

//        $ctr = 0;
//        foreach (file(__DIR__ . '/csv/match_stats.csv') as $line) {
//            if ($ctr > 0) {
//                list($matchId, $teamId, $playerId, $paramId, $paramName, $value) = explode(';', $line);
//
//                if ($paramId = $this->_sanitizeParamId($paramId)) {
//                    MatchParameters::firstOrCreate(
//                        ['id' => $paramId],
//                        ['name' => $this->_sanitizeParamName($paramName)]
//                    );
//                }
//
//                $playerId = $this->_sanitizePlayer($playerId);
//
//                MatchStat::factory()->create([
//                    'match_id' => $matchId,
//                    'team_id' => $teamId,
//                    'player_id' => $playerId,
//                    'param_id' => $paramId,
//                    'value' => $value,
//                ]);
//            }
//            $ctr++;
//
//            if ($ctr == 100000) {
//                break;
//            }
//        }

        LazyCollection::make(function () {
            $handle = fopen(__DIR__ . '/csv/match_stats.csv', 'r');
            while (($line = fgetcsv($handle, 4096)) !== false) {
                $dataString = implode(", ", $line);
                $row = explode(';', $dataString);
                yield $row;
            }
            fclose($handle);
        })
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) {
                $records = $chunk->map(function ($row) {
                    list($matchId, $teamId, $playerId, $paramId, $paramName, $value) = $row;

                    $player = Player::find($playerId);
                    $parameter = MatchParameters::find($paramId);
                    $team = Team::find($teamId);
                    $match = MatchModel::find($matchId);

                    return [
                        'match_id' => $match->id ?? null,
                        'team_id' => $team->id ?? null,
                        'player_id' => $player->id ?? null,
                        'param_id' => $parameter->id ?? null,
                        'value' => $value,
                    ];
                })->toArray();
                DB::table('match_stats')->insert($records);
            });
    }

    private function _sanitizeParamName($value)
    {
        return trim(str_replace('"', '', $value));
    }

    private function _sanitizeParamId($value)
    {
        if ($value > 1) {
            return $value;
        }

        return null;
    }


    private function _sanitizePlayer($playerId)
    {
        $player = Player::find($playerId);
        if (!$player) {
            return null;
        }

        return $playerId;
    }
}
