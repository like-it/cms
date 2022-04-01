{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.rename.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.rename.text'
)}}
{{if(
is.array($request.protected) &&
!in.array($node.url, $request.protected))}}
<a
    class="dropdown-item item-controller"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.name}}/"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-rename-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-controller"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>
{{/if}}