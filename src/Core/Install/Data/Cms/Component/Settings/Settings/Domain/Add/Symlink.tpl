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
'symlink' +
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
'symlink' +
'.' +
'text'
)}}
<a
    class="dropdown-item item-create-symlink"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Create/Symlink/{node.domain}/"
    data-filter-type="{{$request.filter.type}}"
    data-filter-extension="{{$request.filter.extension}}"
    data-limit="{{$request.limit|integer}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-create-symlink"
    >
    </i>
    <span>{{$span.text}}</span>
</a>