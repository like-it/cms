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
'copy' +
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
'copy' +
'.' +
'text'
)}}
<a
class="dropdown-item list-copy"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Copy/{node.domain}/"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-copy"
>
</i>
<span>{{$span.text}}</span>
</a>