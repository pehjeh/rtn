<div>
    <h5>Filters</h5>
    <div class="row">
        <div class="col">
            <select
                class="form-control"
                id="selectedParam"
                wire:model="selectedParam"
                wire:change="dropdownChanged('param_id')"
                {{$isLoading  ? 'disabled': ''}}
            >
                <option value="">-- Select Paramter --</option>
                @foreach($paramNames as $paramName)
                    <option
                        value="{{$paramName['id']}}"
                        wire:key="time().$paramName['id']"
                        {{$paramName['id']==$selectedParam?'selected':''}}
                    >
                        {{$paramName['name']}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select
                class="form-control"
                id="selectedYear"
                wire:model="selectedYear"
                wire:change="dropdownChanged('year')"
                {{$isLoading  ? 'disabled': ''}}
            >
                <option value="">-- Select Year --</option>
                @for($i=$endYear; $i>=$startYear; $i--)
                    <option
                        value="{{$i}}"
                        {{$i==$selectedYear?'selected':''}}
                    >{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col">
            <a wire:click="clearFilters" class="btn btn-primary btn-sm">Clear filters</a>
        </div>
    </div>

</div>

