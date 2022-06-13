{{R3M}}
{{$i.icon = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'action' +
'.' +
'delete' +
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
'action' +
'.' +
'delete' +
'.' +
'text'
)}}
<a
    class="dropdown-item list-delete"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Delete/{node.domain}/"
    data-request-method="DELETE"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
    >
    </i>
    <span>{{$span.text}}</span>
</a>