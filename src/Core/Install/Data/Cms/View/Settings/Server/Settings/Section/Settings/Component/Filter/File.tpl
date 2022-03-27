{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.file.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.file.text'
)}}
<a
    class="dropdown-item list-filter-file"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/?filter[type]=File"
    data-frontend-url="{{route.get(route.prefix() + '-settings-server-settings-settings-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-filter"
    >
    </i>
    <span>{{$span.text}}</span>
</a>