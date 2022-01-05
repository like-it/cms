{R3M}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.' +
$__.subcommand + '.component.options.edit.icon'
)}}
<i
    class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-edit"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$uuid}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-body')}}"
>
</i>