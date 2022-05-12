{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.copy.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.copy.text'
)}}
<a
class="dropdown-item list-move"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Copy/"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-copy"
>
</i>
<span>{{$span.text}}</span>
</a>