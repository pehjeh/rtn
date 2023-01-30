<div>
    <div class="text-center small">
        Displaying: {{count($meta['data'])}} of {{ $this->gettotal() }}
    </div>

    @if ($meta['total'] >0 && !$isLoading)
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link"
                       wire:key="time()"
                       wire:click="getPreviousPageNumber()"
                       aria-label="Previous"
                    >
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for($i=1;$i<=$meta['last_page']; $i++)
                    <li class="page-item {{$this->getClassActive($i, $meta['current_page'])}}">
                        <a
                            class="page-link"
                            wire:key="{{$i}}"
                            wire:click="pageSelected({{$i}})"
                        >
                            {{$i}}
                        </a>
                    </li>
                @endfor
                <li class="page-item">
                    <a class="page-link"
                       wire:key="time()"
                       wire:click="getNextPageNumber()"
                       aria-label="Next"
                    >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>

        </nav>
    @endif
</div>
