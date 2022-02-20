{{R3M}}
{{$field = 'name_old'}}
{{$input.id = $module + '-' + $submodule + '-' + $field + '-' + $request.node.key}}
{{$input.type = 'hidden'}}
{{$input.name = 'node.' + $field }}
{{if(!is.empty(request('node.' + $field)))}}
{{$input.value = request('node.' + $field )}}
{{else}}
{{$input.value = request('node.name')}}
{{/if}}
<input
    id="{{$input.id}}"
    type="{{$input.type}}"
    name="{{$input.name}}"
    value="{{$input.value}}"
/>