{{R3M}}
{{$field = 'prefix'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$validates = [
'validate_string_length',
'validate_string_contains'
]}}
{{if(!is.empty($request.node.key))}}
{{$input.id = $module + '-' + $submodule + '-' + $field + '-' + $request.node.key}}
{{else}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{/if}}
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
{{if(is.empty($input.value))}}
    {{$input.value = config('host.dir.root') + 'View/'}}
{{/if}}
{{$input.placeholder = $label}}
<label for="{{$input.id}}">{{$label}}</label>
<input
    id="{{$input.id}}"
    class="{{$input.class}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
    placeholder="{{$input.placeholder}}"
    readonly="readonly"
/><br>