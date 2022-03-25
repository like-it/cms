{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.delete.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.actions.delete.text'
)}}
<a
    class="dropdown-item list-delete"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/"
    data-request-method="DELETE"
    data-filter-type="{{$request.filter_type}}"
>
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-delete"
    >
    </i>
    <span>{{$span.text}}</span>
</a>