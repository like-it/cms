{{R3M}}
{{$field = 'controller'}}
{{$label = $field|uppercase.first}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{$input.type = 'radio'}}
{{$input.name = 'node.' + $field}}
<label for="{{$input.id}}-automatic">{{$label}}</label><br>
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