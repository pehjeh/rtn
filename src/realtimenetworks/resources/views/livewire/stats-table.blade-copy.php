<div>
    @if ($isLoading)
        <h4 class="text-center">Loading...</h4>
    @else
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Player</th>
                <th scope="col">Statistic</th>
                <th scope="col">Value</th>
                <th scope="col">Year</th>
            </tr>
            </thead>
            <tbody>
            @if (!count($data))
                <tr>
                    <td colspan="4">
                        <h4 class="text-center">No results</h4>
                    </td>
                </tr>
            @endif

            @foreach($data AS $row)
                <tr>
                    <td>
                        @if ($row['player_id'])
                            {{ $row['player']['football_name']}}
                        @else
                            <em class="small">Player Not Found</em>
                        @endif
                    </td>
                    <td>
                        @if ($row['param_id'])
                            {{ $row['parameter']['name']}}
                        @else
                            <em class="small">Player Not Found</em>
                        @endif
                    </td>
                    <td scope="row">
                        {{$row['score']}}
                    </td>
                    <td scope="row">
                        @if ($row['match_id'])
                            <strong>{{ $this->formatDate($row['match']['match_at'], 'Y')}}</strong>
                            <br/>
                            <span class="small">{{ $row['match']['name']}}</span>
                        @else
                            <em class="small">Match Not Found</em>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

