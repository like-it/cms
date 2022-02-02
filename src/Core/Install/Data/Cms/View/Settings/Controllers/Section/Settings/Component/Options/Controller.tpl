{R3M}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.controller.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.controller.text'
)}}
<a
    class="dropdown-item item-controller"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.uuid}}/{{$node.domain}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-controller"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>