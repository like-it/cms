{{R3M}}
{{$field = 'domain'}}
{{html.input([
'id' => $module + '-' + $submodule + '-' + $field,
'name' => $field,
'type' => 'hidden'
])}}
/*
{{$field = 'domain'}}
{{$input.id = $module + '-' + $submodule + '-' + $field}}
{{$input.type = 'hidden'}}
{{$input.name = 'node.' + $field }}
{{$input.value = request('node.' + $field )}}
<input
    id="{{$input.id}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
/>
*/