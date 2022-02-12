{{R3M}}
{{$field = 'domain'}}
{{if(request('node.domain.uuid'))}}
{{$value = request('node.domain.uuid')}}
{{else.if(request('node.domain')) && is.string(request('node.domain'))}}
{{$value = request('node.domain')}}
{{/if}}
{{html.input([
'id' => $module + '-' + $submodule + '-' + $field,
'name' => $field,
'type' => 'hidden'
'value' => $value
])}}