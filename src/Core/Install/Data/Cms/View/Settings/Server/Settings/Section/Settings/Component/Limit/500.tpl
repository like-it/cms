{{R3M}}
{{$span.text = 500}}
<a
class="dropdown-item list-limit"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/?limit=500"
data-frontend-url="{{route.get(route.prefix() + '-settings-server-settings-settings-body')}}"
>
<span>{{$span.text}}</span>
</a>