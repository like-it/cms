{{R3M}}
{{$i.icon = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'filter' +
'.' +
'file' +
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
'filter' +
'.' +
'file' +
'.' +
'text'
)}}
<a
    class="dropdown-item list-filter-file"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/{node.domain}/?limit={{$request.limit}}&filter[type]=File"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' $command + '-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-filter"
    >
    </i>
    <span>{{$span.text}}</span>
</a>