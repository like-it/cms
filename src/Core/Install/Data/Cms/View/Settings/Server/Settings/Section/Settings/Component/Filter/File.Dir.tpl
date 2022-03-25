{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.file.dir.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.filter.file.dir.text'
)}}
{{if($request.filter_type==='All')}}
{{$a.data.default = 'data-default="true"'}}
{{else}}
{{$a.data.default = ''}}
{{/if}}
<a
    class="dropdown-item list-filter-file-dir"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/?filter_type=All"
    data-frontend-url="{{route.get(route.prefix() + '-settings-server-settings-settings-body')}}"
    {{$a.data.default}}
>
<i
    class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-filter"
>
</i>
<span>{{$span.text}}</span>
</a>