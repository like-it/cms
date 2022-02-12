{{R3M}}}
{{$field = 'name'}}
{{html.input([
    'id' => $module + '-' + $submodule + '-' + $field,
    'name' => $field,
    'type' => 'hidden'
])}}