<?php

namespace App\Http\Livewire;

use App\Http\Resources\MatchStateBrowseCollection;
use App\Services\MatchStatService;
use App\Services\MatchStatServiceInterface;
use Livewire\Component;

class Stats extends Component
{
    protected MatchStatServiceInterface $service;

    public array $filters = [
        'page' => 1,
        'param_id' => null,
    ];
    protected array $data = [];
    protected array $meta = [];
    protected $isLoading = false;
    protected $listeners = [
        'setFilter',
//        'refreshTableComponent' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.stats', [
            'data' => $this->data,
            'meta' => $this->meta,
            'isLoading' => $this->isLoading,
            'filters' => $this->filters,
        ]);
    }

    public function getlist()
    {
        $result = $this->service->browse($this->filters)->toArray();
//        dd($result['data']);
        $this->data = $result['data'];
        $this->meta = $result;
        $this->isLoading(false);
    }

    public function setFilter(string $filter, $value)
    {
        if ($filter == 'clear') {
            $this->filters['page'] = 1;
            $this->filters['param_id'] = null;
            $this->filters['year'] = date('Y');
        } else {

            $this->filters[$filter] = $value;

            // Always reset to page 1
            // when other filters are used
            if ($filter != 'page') {
                $this->filters['page'] = 1;
            }
        }

        $this->isLoading();
        $this->getList();
    }

    public function isLoading($status = true)
    {
        $this->isLoading = $status;
        $this->emit('refreshTableComponent');
    }

    public function mount()
    {
        $this->getList();
    }

    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->service = app(MatchStatService::class);
    }
}
