{{R3M}}
{{$field = 'host'}}
{{$label = 'Domain'}}
{{$label =  $label + '*'}}
{{$validates = [
'validate_string_length',
'validate_contains_a_z'
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
<label for="{{$module}}-{{$submodule}}-{{$field}}">{{$label}}</label>
<input
    id="{{$input.id}}"
    class="{{$input.class}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
    placeholder="{{$input.placeholder}}"
/><br>