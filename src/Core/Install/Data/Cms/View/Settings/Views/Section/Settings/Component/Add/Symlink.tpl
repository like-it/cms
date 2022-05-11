{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.symlink.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.symlink.text'
)}}
<a
    class="dropdown-item item-create-symlink"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Create/Symlink/"
    data-filter-type="{{$request.filter.type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-move"
    >
    </i>
    <span>{{$span.text}}</span>
</a>