@php 
    $agents = get_agents();
@endphp

<select id="maxprice" data-placeholder="{{ __('Agents') }}" name="author_id" class="form-control">
    <option value="">&nbsp;</option>
    @if (theme_option('max_price'))
        @foreach ($agents as $key => $value)
            <option value="{{$value->id}}">{{$value->first_name}} {{$value->last_name}}</option>
        @endforeach
    @endif
</select>

