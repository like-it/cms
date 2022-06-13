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
'move' +
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
'move' +
'.' +
'text'
)}}
<a
class="dropdown-item list-move"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Move/{node.domain}/"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-move"
>
</i>
<span>{{$span.text}}</span>
</a>