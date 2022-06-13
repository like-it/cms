{{R3M}}
{{$i.icon = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'add' +
'.' +
'upload' +
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
'add' +
'.' +
'upload' +
'.' +
'text'
)}}
<a
    class="dropdown-item list-upload"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Upload/{node.domain}/"
    data-filter-type="{{$request.filter.type}}"
    data-filter-extension="{{$request.filter.extension}}"
    data-limit="{{$request.limit|integer}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-upload"
    >
    </i>
    <span>{{$span.text}}</span>
</a>