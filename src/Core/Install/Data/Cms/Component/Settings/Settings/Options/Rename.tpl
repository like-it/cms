{{R3M}}
{{$i.icon = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'options' +
'.' +
'rename' +
'.' +
'icon'
)}}
{{$span.text = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'options' +
'.' +
'rename' +
'.' +
'text'
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