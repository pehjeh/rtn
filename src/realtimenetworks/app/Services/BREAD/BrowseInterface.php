<?php

namespace App\Services\BREAD;

use Illuminate\Pagination\LengthAwarePaginator;

interface BrowseInterface
{
    public function browse(array $params = []): LengthAwarePaginator;
}
