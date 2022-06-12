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
'dir' +
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
'dir' +
'.' +
'text'
)}}
<a
    class="dropdown-item item-create-dir"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Create/Directory/{node.domain}"
    data-filter-type="{{$request.filter.type}}"
    data-filter-extension="{{$request.filter.extension}}"
    data-limit="{{$request.limit|integer}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-create-directory"
    >
    </i>
    <span>{{$span.text}}</span>
</a>