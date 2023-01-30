<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ctr = 0;
        foreach (file(__DIR__ . '/csv/teams.csv') as $line) {
            if ($ctr > 0) {
                list($id, $name, $shortName) = explode(';', $line);
                Team::factory()->create([
                    'id' => $id,
                    'name' => $name,
                    'short_name' => $shortName,
                ]);
                }
            $ctr++;
        }
    }
}
