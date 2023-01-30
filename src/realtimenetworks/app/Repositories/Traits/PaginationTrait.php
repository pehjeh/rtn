<?php

namespace App\Repositories\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 *
 */
trait PaginationTrait
{
    protected int $paginationPage = 1;

    protected int $paginationPerPage = 25;


    public function page(int $page): self
    {
        $this->paginationPage = $page;
        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->paginationPerPage = $perPage;
        return $this;
    }

    public function paginate(int|null $page = null): LengthAwarePaginator
    {
        if (!$page) {
            $page = $this->paginationPage;
        }

        $perPage = $this->paginationPerPage;
        if ($this->model->getQuery()->limit) {
            $perPage = $this->model->getQuery()->limit;
        }

        return $this->model->paginate(
            $perPage,
            ['*'],
            'page',
            $page
        );
    }
}
