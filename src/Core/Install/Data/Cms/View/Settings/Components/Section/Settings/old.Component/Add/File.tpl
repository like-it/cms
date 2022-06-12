{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.file.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.add.file.text'
)}}
<a
    class="dropdown-item item-create-file"
    data-frontend-url="{{
        route.get(
        route.prefix() +
        '-' +
        $module +
        '-' +
        $submodule +
        '-' +
        'add-template' +
        '-' +
        'body-node-domain', [
        'node.domain' => '{node.domain}'
    ])}}"
    data-filter-type="{{$request.filter.type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-create-file"
    >
    </i>
    <span>{{$span.text}}</span>
</a>