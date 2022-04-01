{{R3M}}
{{$i.icon = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.addons.symlink.icon'
)}}
{{$span.text = __(
$__.module +
'.' +
$__.submodule +
'.section.' +
$__.command +
'.component.addons.symlink.text'
)}}
<a
class="dropdown-item item-new-symlink"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Move/"
data-filter[type]="{{$request.filter.type}}"
>
<i
class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-move"
>
</i>
<span>{{$span.text}}</span>
</a>