<?php

namespace Tests;

use app\Repositories\MatchStats\MatchStatRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication
        //  //     RefreshDatabase
        // DatabaseMigrations // <- this rolls back the db after the first test
        ;

    protected static bool $setUpHasRunOnce = false;


    public function setUp(): void
    {
        parent::setUp();
        // var_dump(static::$setUpHasRunOnce);
        if (!static::$setUpHasRunOnce) {
            Artisan::call('db:wipe');
            Artisan::call('migrate');
            Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
            static::$setUpHasRunOnce = true;
        }


        $repository = app(MatchStatRepository::class);
        $repository->cacheRebuildParamNames();
        // Artisan::call('migrate:fresh');
        // Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        // $this->artisan('db:seed');
    }
}
