{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.move.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.move.text'
)}}
<a
class="dropdown-item list-move"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Move/"
data-filter-type="{{$request.filter_type}}"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-move"
>
</i>
<span>{{$span.text}}</span>
</a>