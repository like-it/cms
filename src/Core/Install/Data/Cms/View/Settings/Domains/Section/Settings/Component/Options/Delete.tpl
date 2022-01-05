{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.' +
$__.subcommand + '.component.options.delete.icon'
)}}
<i
    class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$uuid}}"
    data-request-method="DELETE"
    data-name="{{$node.from_email}}"
>
</i>