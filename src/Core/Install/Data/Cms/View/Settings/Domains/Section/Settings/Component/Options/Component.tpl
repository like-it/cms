{R3M}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.component.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.component.text'
)}}
<a
    class="dropdown-item"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.uuid}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-edit"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>