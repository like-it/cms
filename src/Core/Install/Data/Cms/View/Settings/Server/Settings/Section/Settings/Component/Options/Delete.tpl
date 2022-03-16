{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.delete.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.options.delete.text'
)}}
{{if(!in.array($node.url, [
'/Application/Public/.htaccess',
'/Application/Public/index.php'
]))}}
<a
    class="dropdown-item item-delete"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.encode}}/{{$node.domain}}"
    data-request-method="DELETE"
    data-name="{{$node.name}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
    >
    </i>
    <span>{{$span.text}}</span>
</a>
{{/if}}