{{R3M}}
{{$span.text = 100}}
<a
class="dropdown-item list-limit"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/?limit=100&filter[type]={{$request.filter.type}}"
data-frontend-url="{{route.get(route.prefix() + '-settings-server-settings-settings-body')}}"
>
<span>{{$span.text}}</span>
</a>