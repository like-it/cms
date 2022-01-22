{{R3M}}
{{$field = 'path'}}
{{$label = $field|uppercase.first}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{$input.type = 'radio'}}
{{$input.name = 'node.' + $field}}
<label for="{{$input.id}}-automatic">{{$label}}</label><br>
{{if(!is.empty(request('node.' + $field)))}}
<input
    type="{{$input.type}}"
    id="{{$input.id}}-automatic"
    name="{{$input.name}}.{{$input.type}}"
    value="automatic"
/>
<label for="{{$input.id}}-automatic">
    Automatic
</label>
<br>
<input
    type="{{$input.type}}"
    id="{{$input.id}}-custom"
    name="{{$input.name}}.{{$input.type}}"
    value="custom"
    checked="checked"
/>
<label for="{{$input.id}}-custom">
    Custom
</label>
<br>
{{$input.type = 'text'}}
{{if(request('has', 'node.' + $field + '.' + $input.type))}}
{{$input.value = request('node.' + $field + '.' + $input.type)}}
{{elseif(request('has', 'node.' + $field) && is.scalar(request('node.' + $field)))}}
{{$input.value = request('node.' + $field)}}
{{/if}}
{{$input.placeholder = $label}}
<input
    id="{{$input.id}}"
    class="{{$input.class}}"
    type="{{$input.type}}"
    name="{{$input.name}}.{{$input.type}}"
    value="{{$input.value}}"
    placeholder="{{$input.placeholder}}"
/>
<br>
{{else}}
<input
    type="{{$input.type}}"
    id="{{$input.id}}-automatic"
    name="{{$input.name}}.{{$input.type}}"
    checked="checked"
    value="automatic"
/>
<label for="{{$input.id}}-automatic">
    Automatic
</label>
<br>
<input
    type="{{$input.type}}"
    id="{{$input.id}}-custom"
    name="{{$input.name}}.{{$input.type}}"
    value="custom"
/>
<label for="{{$input.id}}-custom">
    Custom
</label>
<br>
{{$input.type = 'text'}}
{{$input.value = request('node.' + $field + '.' + $input.type)}}
{{if(is.empty($input.value))}}
    {{$input.value = request('node.' + $field)}}
{{/if}}
{{$input.placeholder = $label}}
<input
    id="{{$input.id}}"
    class="{{$input.class}}"
    type="{{$input.type}}"
    name="{{$input.name}}.{{$input.type}}"
    value="{{$input.value}}"
    placeholder="{{$input.placeholder}}"
/>
<br>
{{/if}}
