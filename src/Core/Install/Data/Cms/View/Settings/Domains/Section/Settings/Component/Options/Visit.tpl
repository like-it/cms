{R3M}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.' +
$__.subcommand +
'.component.options.visit.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.' +
$__.subcommand +
'.component.options.visit.text'
)}}
{{if(!is.empty($node.subdomain))}}
{{$node.url = 'https://' + $node.subdomain + '.' + $node.host + '.' + $node.extension}}
{{else}}
{{$node.url = 'https://' + $node.host + '.' + $node.extension}}
{{/if}}
<a
    class="dropdown-item item-visit"
    data-frontend-url="{{$node.url}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-edit"
        data-name="{{$node.name}}"
    >
    </i>
    <span>{{$span.text}}</span>
</a>