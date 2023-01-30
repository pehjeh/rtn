<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Repositories\MatchParameter\MatchParameterRepository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ParametersSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(PlayerSeeder::class);
        $this->call(MatchSeeder::class);
        $this->call(MatchStatSeeder::class);
    }
}
