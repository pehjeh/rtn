<?php

namespace Tests\Unit;

use App\Services\TeamService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class TeamsUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_paginated_list()
    {
        $service = app(TeamService::class);

        $params = [
            'sortBy' => 'name',
            'orderBy' => 'ASC',
            'perPage' => 3,
            'page' => 1,
        ];

        $result = $service->browse($params);

        $this->assertTrue($result instanceof LengthAwarePaginator);
        $this->assertTrue($result->perPage() == $params['perPage']);
        $this->assertTrue($result->currentPage() == $params['page']);
    }
}
