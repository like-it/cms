{{R3M}}
{{$field = 'method'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$validates = [
'validate_in_list_json',
]}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{for.each($validates as $validate)}}
    {{if(request.error($field + '.' + $validate) === true)}}
        {{$input.class = 'form-control alert-danger'}}
        {{if(is.empty($request.focus))}}
            {{$request.focus = 'node.' + $field}}
        {{/if}}
    {{/if}}
{{/for.each}}
{{$input.name = 'node.' + $field + '[]'}}
{{$input.url = config('framework.dir.data') + 'Method.json'}}
{{dd($input.url)}}
{{$input.options = json.select($select.url, 'method')}}
<label for="{{$select.id}}">{{$label}}</label>
<input
    type="checkbox"
    id=""
    name="vehicle1"
    value="Bike"
>
<select
    id="{{$select.id}}"
    class="{{$select.class}}"
    name="{{$select.name}}"
>
    {{if(
        is.array($select.options) ||
        is.object($select.options)
    )}}
        {{for.each($select.options as $value => $option)}}
            {{if($select.selected === $value)}}
                <option value="{{$value}}" selected="selected">{{$option.name}}</option>
            {{else}}
                <option value="{{$value}}">{{$option.name}}</option>
            {{/if}}
        {{/for.each}}
    {{/if}}

</select>
<br>