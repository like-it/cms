{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.addons.upload.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.addons.upload.text'
)}}
<a
    class="dropdown-item item-upload"
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