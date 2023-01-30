<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class StatsTable extends Component
{
    public array $data = [];
    protected bool $isLoading = false;

    protected $listeners = [
        'refreshTableComponent' => '$refresh',
    ];

    public function render()
    {
//        dd(count($this->data));
        return view('livewire.stats-table', [
            'data' => $this->data,
            'time' => time(),
            'isLoading' => $this->isLoading,
        ]);
    }

    public function mount($data, $isLoading)
    {
        $this->data = $data;
    }


    public function formatDate($date, string $format = 'M d, Y h:i A')
    {
        return Carbon::createFromTimeString($date)->format($format);
    }

}
