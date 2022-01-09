{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.' +
$__.subcommand +
'.component.options.delete.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.' +
$__.subcommand +
'.component.options.delete.text'
)}}
<a
    class="dropdown-item item-delete"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.uuid}}"
    data-request-method="DELETE"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>