{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.dir.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.dir.text'
)}}
<a
    class="dropdown-item item-create-dir"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Create/Directory/"
    data-filter-type="{{$request.filter.type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-move"
    >
    </i>
    <span>{{$span.text}}</span>
</a>