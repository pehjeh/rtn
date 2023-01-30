<?php

namespace App\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

trait Cacheable
{


    public function cacheBuild()
    {
        $this->_cacheValidateProperties();

        $this->cacheFlush();

        Cache::store($this->cacheDriver)->put($this->cacheKey, self::all());
    }

    public function cached(bool $force = false): Collection
    {
        $this->_cacheValidateProperties();

        if (!Cache::store($this->cacheDriver)->has($this->cacheKey)) {
            $this->cacheBuild();
        }

        return Cache::store($this->cacheDriver)->get($this->cacheKey);
    }

    public function cacheFlush()
    {
        Cache::store($this->cacheDriver)->forget($this->cacheKey);
    }

    private function _cacheValidateProperties()
    {
        if (!property_exists($this, 'cacheDriver')) {
            throw new Exception('Cache Driver property missing');
        }

        if (!property_exists($this, 'cacheKey')) {
            throw new Exception('Cache Key property missing');
        }
    }
}
