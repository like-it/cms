{{R3M}}
{{$span.text = 50}}
<a
class="dropdown-item list-limit"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/?limit=50"
data-frontend-url="{{route.get(route.prefix() + '-settings-server-settings-settings-body')}}"
>
<span>{{$span.text}}</span>
</a>