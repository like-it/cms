{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.file.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.file.text'
)}}
<a
    class="dropdown-item item-create-file"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Create/File/"
    data-filter-type="{{$request.filter.type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-create-file"
    >
    </i>
    <span>{{$span.text}}</span>
</a>