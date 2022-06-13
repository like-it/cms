{{R3M}}
{{$i.icon = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'options' +
'.' +
'edit' +
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
'options' +
'.' +
'edit' +
'.' +
'text'
)}}
{{$node.extension = file.extension($node.url)}}
{{if(
!in.array($node.extension, image.extensions()) &&
$node.type !== 'Dir'
)}}
<a
    class="dropdown-item item-edit"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.raw.encode}}/{{$node.domain}}/"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-template-body')}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-edit"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>
{{/if}}