<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(__DIR__ . '/csv/players.csv', 'r');
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
                    list($id, $firstName, $lastName, $footballName) = $row;

                    return [
                        'id' => $id,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'football_name' => $footballName,
                    ];
                })->toArray();
                DB::table('players')->insert($records);
            });

        // We are manually trigger the cachbuild
        // because we are not using Eloquent to
        // insert the records as a result the
        // observer is not triggered
        $Match = new Player();
        $Match->cacheBuild();
    }
}
