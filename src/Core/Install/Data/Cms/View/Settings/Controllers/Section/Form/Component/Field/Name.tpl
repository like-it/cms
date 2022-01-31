{{R3M}}
{{$field = 'name'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$validates = [
'validate_string_length',
'validate_string_contains'
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
{{$input.type = 'text'}}
{{$input.name = 'node.' + $field}}
{{$input.value = request('node.' + $field)}}
{{$input.placeholder = $label}}
<label for="{{$input.id}}">{{$label}}</label>
<input
    id="{{$input.id}}"
    class="{{$input.class}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
    placeholder="{{$input.placeholder}}"
/><br>