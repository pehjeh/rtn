<?php

namespace Database\Seeders;

use App\Models\MatchModel;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(__DIR__ . '/csv/matches.csv', 'r');
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
                    list($id, $matchName, $matchDate, $team1Id, $team1Score, $team2Id, $team2Score) = $row;

                    return [
                        'id' => $id,
                        'name' => $matchName,
                        'match_at' => $matchDate,
                        'team_1_id' => $this->_sanitizeId($team1Id),
                        'team_2_id' => $this->_sanitizeId($team1Id),
                        'team_1_score' => $this->_sanitizeScore($team1Score),
                        'team_2_score' => $this->_sanitizeScore($team2Score),
                    ];
                })->toArray();
                DB::table('matches')->insert($records);
            });

        // We are manually trigger the cachbuild
        // because we are not using Eloquent to
        // insert the records as a result the
        // observer is not triggered
        $Match = new MatchModel();
        $Match->cacheBuild();
    }


    private function _sanitizeId($id)
    {
        if (!is_numeric($id)) {
            return null;
        }

        $team = Team::find($id);

        return ($team) ? $id : null;
    }

    private function _sanitizeScore($score)
    {
        if (!is_numeric($score)) {
            return null;
        }

        return $score;
    }
}
