{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.addons.file.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.addons.file.text'
)}}
<a
    class="dropdown-item item-new-file"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/"
    data-request-method="DELETE"
    data-filter[type]="{{$request.filter.type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
    >
    </i>
    <span>{{$span.text}}</span>
</a>