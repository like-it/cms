{{R3M}}
{{$field = 'update'}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.type = 'hidden'}}
{{$input.name = 'request-method' }}
{{$input.value = 'PUT'}}
<input
    id="{{$input.id}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
/>