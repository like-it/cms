{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.edit.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.edit.text'
)}}
<a
    class="dropdown-item item-edit"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.name}}/{{$node.domain}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-controller-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-edit"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>