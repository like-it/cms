{{R3M}}
{{$field = 'subdomain'}}
{{$label = __($__.module + '.' + $__.submodule + '.section.form.component.field.' + $field)}}
{{if(is.empty($label))}}
{{$label = $field|uppercase.first}}
{{/if}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{$input.type = 'text'}}
{{$input.name = 'node.' + $field }}
{{$input.value = request('node.' + $field)}}
{{$input.placeholder = $label }}
<label for="{{$module}}-{{$submodule}}-{{$field}}">{{$label}}</label>
<input
    id="{{$module}}-{{$submodule}}-{{$field}}"
    class="{{$input.class}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
    placeholder="{{$input.placeholder}}"
/><br>