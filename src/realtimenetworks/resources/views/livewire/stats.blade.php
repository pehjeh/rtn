<div>
    <div>
        @livewire( 'stats-filters', [ 'filters' => $filters, 'isLoading' => $isLoading, ], key('stats-filter-'.time()) )
    </div>
    <div>
        @livewire( 'stats-table', [ 'data' => $data, 'isLoading' => $isLoading, ], key('stats-table-'.time()) )
    </div>
    <div>
        @livewire('stats-pagination', ['meta' => $meta, 'isLoading' => $isLoading, ], key('stats-table-'.time()))
    </div>
</div>
