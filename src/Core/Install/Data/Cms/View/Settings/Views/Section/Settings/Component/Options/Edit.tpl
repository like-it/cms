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
{{dd($node)}}
<a
    class="dropdown-item item-edit"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.encode}}/{{$node.domain}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-template-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-edit"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>