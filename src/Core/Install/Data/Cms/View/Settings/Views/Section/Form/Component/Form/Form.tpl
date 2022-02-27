{{R3M}}
{{if(in.array($command,['add-template']))}}
{{$data.url = server.url('core') + $require.module + '/' + $require.submodule + '/' + $require.command + '/'}}
{{$data.error = route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $command + '-' + $subcommand + '-node-domain', ['node.domain' => '{node.domain}'])}}
{{$require.action = 'Add'}}
{{else.if(in.array($command,['edit-template']))}}
{{$data.url = server.url('core') + $require.module + '/' + $require.submodule + '/' + $request.node.uuid}}
{{$data.error = route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $command + '-' + $subcommand)}}
{{$require.action = 'Edit'}}
{{/if}}
<form
    name="{{$module}}-{{$submodule}}-{{$command}}-form"
    method="post"
    data-url="{{$data.url}}"
    data-url-error="{{$data.error}}"
>
    {{require($prefix + $require.submodule + '/Section/Form/Component/Error/Error.tpl')}}
    {{require($prefix + $require.submodule + '/Section/Form/Component/Form/' + $require.action +'.tpl')}}
</form>