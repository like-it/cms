{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.view.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.view.text'
)}}
{{$node.extension = file.extension($node.url)}}
{{if(in.array($node.extension, image.extensions()))}}
<a
    class="dropdown-item item-view"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|raw.url.encode}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-view-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-view"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>
{{/if}}
