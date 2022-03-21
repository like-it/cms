{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.delete.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.delete.text'
<a
class="dropdown-item item-delete"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Move/"
data-request-method="POST"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
>
</i>
<span>{{$span.text}}</span>
</a>