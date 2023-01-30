<?php

namespace Tests\Unit;

use App\Services\MatchStatService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MatchStatUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_param_names()
    {
        $service = app(MatchStatService::class);
//        DB::connection()->enableQueryLog();
        $result = $service->getFromCache();

//        DB::getQueryLog();
        $this->assertTrue(true);
    }
}
