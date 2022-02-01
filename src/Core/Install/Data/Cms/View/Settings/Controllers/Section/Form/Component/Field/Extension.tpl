{{R3M}}
{{$field = 'extension'}}
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
        value="php"
/>
<label for="{{$input.id}}">
    Php
</label>