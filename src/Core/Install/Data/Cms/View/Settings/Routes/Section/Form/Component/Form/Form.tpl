{{R3M}}
{{if(in.array($command,['add-' + $submodule, 'add-redirect']))}}
{{$data.url = server.url('core') + $require.module + '/' + $require.submodule + '/' + $require.command + '/'}}
{{$data.error = route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $command + '-' + $subcommand + '-node-domain', ['node.domain' => '{node.domain}'])}}
{{$require.button = 'Add'}}
{{else.if(in.array($command,['edit-' + $submodule, 'edit-redirect']))}}
{{$data.url = server.url('core') + $require.module + '/' + $require.submodule + '/' + $request.node.uuid}}
{{$data.error = route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $command + '-' + $subcommand)}}
{{$require.button = 'Edit'}}
{{/if}}
<form
    name="{{$module}}-{{$submodule}}-{{$command}}-form"
    method="post"
    data-url="{{$data.url}}"
    data-url-error="{{$data.error}}"
>
    {{require($prefix + $require.submodule + '/Section/Form/Component/Error/Error.tpl')}}
    <div class="mb-3">
        {{for.each($fields as $field)}}
        {{$require.basename = $field|uppercase.first.sentence:'.'}}
        {{require($prefix + $require.submodule + '/Section/Form/Component/Field/' + $require.basename + '.tpl')}}
        {{/for.each}}
    </div>
    <div class="mb-3">
        {{require($prefix + $require.submodule + '/Section/Form/Component/Button/' + $require.button + '.tpl')}}
    </div>
</form>