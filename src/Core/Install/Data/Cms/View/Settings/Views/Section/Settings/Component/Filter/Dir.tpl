{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.dir.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.dir.text'
)}}
<a
    class="dropdown-item list-filter-dir"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/{node.domain}/?limit={{$request.limit}}&filter[type]=Dir"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' $command + '-body')}}"
>
<i
    class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-filter"
>
</i>
<span>{{$span.text}}</span>
</a>