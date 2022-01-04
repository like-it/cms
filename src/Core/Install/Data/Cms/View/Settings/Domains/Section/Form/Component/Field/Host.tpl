{R3M}
{{$field = 'host'}}
{{$label = $field|uppercase.first}}
{{$label =  $label + '*'}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{if(request.error('host.validate_string_length') === false)}}
{{$input.class = 'form-control'}}
{{else}}
{{$input.class = 'form-control alert-danger'}}
{{if(is.empty($request.focus))}}
{{$request.focus = 'node.' + $field}}
{{/if}}
{{/if}}
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