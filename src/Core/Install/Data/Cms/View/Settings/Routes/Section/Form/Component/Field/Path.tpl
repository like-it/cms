{{R3M}}
{{$field = 'path'}}
{{$label = $field|uppercase.first}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{$input.type = 'radio'}}
{{$input.name = 'node.' + $field}}
<label for="{{$input.id}}">{{$label}}</label><br>
<input
    type="{{$input.type}}"
    id="{{$input.id}}"
    name="{{$input.name}}.{{$input.type}}"
    checked="checked"
    value="automatic"
/>
<span>
    Automatic
</span>
<br>
<input
    type="{{$input.type}}"
    id="{{$input.id}}"
    name="{{$input.name}}.{{$input.type}}"
    value="custom"
/>
<span>
    Custom
</span>
<br>
{{$input.type = 'text'}}
{{$input.value = request('node.' + $field + '.' + $input.type)}}
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