{{R3M}}
{{$field = 'extension'}}
{{$label = $field|uppercase.first}}
{{$label += '*'}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.class = 'form-control'}}
{{$input.type = 'radio'}}
{{$input.name = 'node.' + $field}}
{{$input.value = '.php'}}
{{$input.checked = true}}
<label for="{{$input.id}}">{{$label}}</label><br>
<input
        type="{{$input.type}}"
        id="{{$input.id}}"
        name="{{$input.name}}.{{$input.type}}"
        {{if(!is.empty($input.checked))}}
        checked="checked"
        {{/if}}
        value="{{$input.value}}"
/>
<label for="{{$input.id}}">
    {{$input.value}}
</label>