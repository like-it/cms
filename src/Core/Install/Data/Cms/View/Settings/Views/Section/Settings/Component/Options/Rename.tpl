{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.rename.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.rename.text'
)}}
<a
    class="dropdown-item item-rename"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.raw.encode}}/{{$node.domain}}"
    data-name="{{$node.name}}"
    data-source="{{$node.url}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-rename"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>