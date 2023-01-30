<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StatsPagination extends Component
{
    public $meta;
    public $page = 1;
    public $isLoading = false;
    protected $lastPageNumber;

    protected $listeners = [
//        'pageSelected',
        'refreshPaginationComponent' => '$refresh',
    ];


    public function render()
    {
        return view('livewire.stats-pagination', [
            'meta' => $this->meta,
            'isLoading' => $this->isLoading,
        ]);
    }

    public function pageSelected($page)
    {
        $this->emitUp('setFilter', 'page', $page);
    }

    public function getTotal()
    {
        if (count($this->meta['data']) >= $this->meta['total']) {
            return count($this->meta['data']);
        }

        return $this->meta['total'];
    }


    public function getClassActive($currentIndex, $currentPage)
    {
        return ($currentIndex == $currentPage) ? 'active' : '';
    }

    public function getNextPageNumber()
    {
        $nextPageNumber = $this->meta['current_page'] + 1;

        if ($nextPageNumber > $this->meta['last_page']) {
            $nextPageNumber = $this->meta['last_page'];
        }

        $this->pageSelected($nextPageNumber);
    }

    public function getPreviousPageNumber()
    {
        $previousPageNumber = $this->meta['current_page'] - 1;

        if ($previousPageNumber < 1) {
            $previousPageNumber = 1;
        }

        $this->pageSelected($previousPageNumber);
    }

    public function mount($meta, $isLoading)
    {
        $this->meta = $meta;
        $this->isLoading = $isLoading;
    }


}
