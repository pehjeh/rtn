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
                    <?php $row = (array)$row; ?>
                <tr>
                    <td>
                        {{ $row['football_name']}}

                    </td>
                    <td>
                        {{ $row['parameter_name']}}
                    </td>
                    <td scope="row">
                        {{$row['score']}}
                    </td>
                    <td scope="row">
                        <strong>{{ $this->formatDate($row['match_at'], 'Y')}}</strong>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

