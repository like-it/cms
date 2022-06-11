{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.upload.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.upload.text'
)}}
<a
    class="dropdown-item list-upload"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Upload/"
    data-filter-type="{{$request.filter.type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-upload"
    >
    </i>
    <span>{{$span.text}}</span>
</a>