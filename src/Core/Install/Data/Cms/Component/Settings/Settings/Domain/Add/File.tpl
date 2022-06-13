{{R3M}}
{{$i.icon = __(
'component' +
'.' +
$__.module +
'.' +
'settings' +
'.' +
'add' +
'.' +
'file' +
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
'add' +
'.' +
'file' +
'.' +
'text'
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
    data-filter-extension="{{$request.filter.extension}}"
    data-limit="{{$request.limit|integer}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-create-file"
    >
    </i>
    <span>{{$span.text}}</span>
</a>