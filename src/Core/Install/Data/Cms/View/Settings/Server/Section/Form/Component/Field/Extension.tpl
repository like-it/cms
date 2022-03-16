{{R3M}}
{{$field = 'extension'}}
{{$label = $field|uppercase.first}}
{{$label += '*'}}
{{$input.id = $module + '-' + $submodule + '-' + $field + '-' + $request.node.key}}
{{$input.class = 'form-control'}}
{{$input.type = 'radio'}}
{{$input.name = 'node.' + $field}}
{{$input.value = '.tpl'}}
{{$input.checked = true}}
<label for="{{$input.id}}">{{$label}}</label><br>
<input
        type="{{$input.type}}"
        id="{{$input.id}}-tpl"
        name="{{$input.name}}"
        {{if(!is.empty($input.checked))}}
        checked="checked"
        {{/if}}
        value="{{$input.value}}"
/>
<label for="{{$input.id}}-tpl">
    {{$input.value}}
</label>
{{$input.value = '.js'}}
<input
    type="{{$input.type}}"
    id="{{$input.id}}-js"
    name="{{$input.name}}"
    value="{{$input.value}}"
/>
<label for="{{$input.id}}-js">
    {{$input.value}}
</label>
{{$input.value = '.css'}}
<input
    type="{{$input.type}}"
    id="{{$input.id}}-css"
    name="{{$input.name}}"
    value="{{$input.value}}"
/>
<label for="{{$input.id}}-css">
    {{$input.value}}
</label>