{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.file.dir.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.file.dir.text'
)}}
<a
class="dropdown-item list-filter-file-dir"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/?filter=file+dir"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-filter"
>
</i>
<span>{{$span.text}}</span>
</a>