{{R3M}}
<form
    name="{{$module}}-{{$submodule}}-{{$command}}-form"
    method="post"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/"
    data-url-error="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $command + '-' + $subcommand)}}"
>
    {{require($prefix + $require.submodule + '/Section/Form/Component/Error/Error.tpl')}}
    <div class="mb-3">
        {{for.each($fields as $field)}}
        {{$require.basename = $field|uppercase.first.sentence:'.'}}
        {{require($prefix + $require.submodule + '/Section/Form/Component/Field/' + $require.basename + '.tpl')}}
        {{/for.each}}
    </div>
    <div class="mb-3">
        {{require($prefix + $require.submodule + '/Section/Form/Component/Button/' + $require.command + '.tpl')}}
    </div>
</form>