<?php

namespace App\Repositories\MatchParameter;

use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    private $cacheKeys = [
        'param_names' => 'matchstat_param_name_cache',
    ];

    public function cacheRebuildParamNames()
    {
        Cache::store('redis')->delete($this->cacheKeys['param_names']);

        $list = $this->makeModel()
            ->select('id', 'name')
            ->orderBy('name', 'ASC')
            ->get()
            ->toArray();

        Cache::store('redis')
            ->put(
                $this->cacheKeys['param_names'],
                $list,
                3200
            );

        return $this->parameterList();
    }

    public function parameterList()
    {
        $list = Cache::store('redis')->get($this->cacheKeys['param_names']);

        if (!$list) {
            $this->cacheRebuildParamNames();
        }

        return Cache::store('redis')->get($this->cacheKeys['param_names']);
    }
}
