{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.delete.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.delete.text'
)}}
<a
    class="dropdown-item item-delete"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.name}}/{{$node.domain}}"
    data-request-method="DELETE"
    data-name="{{$node.name}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
    >
    </i>
    <span>{{$span.text}}</span>
</a>