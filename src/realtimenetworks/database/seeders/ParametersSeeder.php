<?php

namespace Database\Seeders;

use App\Models\MatchParameters;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class ParametersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = [];
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
            ->each(function (LazyCollection $chunk) use (&$ids) {
                $records =
                    $chunk->reject(function ($row) use (&$ids) {
                    list($matchId, $teamId, $playerId, $paramId, $paramName, $value) = $row;

                    if (!isset($ids[$paramId])) {
                        $ids[$paramId] = $paramName;
                    } else {
                        return true;
                    }
                })->map(function($row) {
                        list($matchId, $teamId, $playerId, $paramId, $paramName, $value) = $row;
                        return [
                            'id' => $paramId,
                            'name' => $this->_sanitizeParamName($paramName),
                        ];
                    })->toArray();
                DB::table('match_parameters')->insert($records);

            });

        // We are manually trigger the cachbuild
        // because we are not using Eloquent to
        // insert the records as a result the
        // observer is not triggered
        $Match = new MatchParameters();
        $Match->cacheBuild();
    }

    private function _sanitizeParamName($value)
    {
        return trim(str_replace('"', '', $value));
    }
}
