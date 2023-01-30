<?php

namespace App\Http\Livewire;

use App\Models\MatchParameters;
use Carbon\Carbon;
use Livewire\Component;

class StatsFilters extends Component
{
    protected bool $isLoading = false;
    public array $filters = [];
    public array $paramNames = [];
    public $startyear = 2009;
    public $endYear = 2022;
    public $selectedYear;
    public $selectedParam;


    public function mount($filters, $isLoading)
    {
        $this->isLoading = $isLoading;
        $this->filters = $filters;

        $this->selectedYear = $filters['year'] ?? date('Y');
        $this->selectedParam = $filters['param_id'] ?? null;

        $Parameters = new MatchParameters();

        /*
         * This can be shortened if the CACHED
         * query results have been ordered by name
         * in ascending order. This is just to showcase
         * how convenient it is to manipulate arrays
         * in Laravel.
         */
        $this->paramNames = collect($Parameters->cached()->toArray())
            ->sortBy('name')
            ->map(function ($row) {
                return [
                    'id' => $row['id'],
                    'name' => $row['name']
                ];
            })
            ->values()
            ->toArray();
    }

    public function dropdownChanged($type)
    {
        switch ($type) {
            case 'year':
                $value = $this->selectedYear;
                break;
            case 'param_id':
            default:
                $value = $this->selectedParam;
                break;
        }

        $value = strlen($value) ? $value : null;

        $this->emit('setFilter', $type, $value);
    }

    public function clearFilters()
    {
        $this->emit('setFilter', 'clear', null);
    }


    public function render()
    {
        return view('livewire.stats-filters', [
            'isLoading' => $this->isLoading,
            'filters' => $this->filters,
            'startYear' => $this->startyear,
            'endYear' => $this->endYear,
        ]);
    }

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->endYear = Carbon::now()->format('Y');
    }
}
