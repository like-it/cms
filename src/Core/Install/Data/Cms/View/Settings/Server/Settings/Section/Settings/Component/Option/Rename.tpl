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
{{if(is.empty($node.protected))}}
<a
    class="dropdown-item item-rename"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.name}}/"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-rename-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-rename"
        data-name="{{$node.name}}"
        data-source="{{$node.url}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>
{{/if}}