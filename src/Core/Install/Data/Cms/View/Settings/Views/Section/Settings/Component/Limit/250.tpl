{{R3M}}
{{$span.text = 250}}
<a
class="dropdown-item list-limit"
data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/{node.domain}/?limit=250&filter[type]={{$request.filter.type}}"
data-frontend-url="{{route.get(route.prefix() + '-settings-server-settings-settings-body')}}"
>
<span>{{$span.text}}</span>
</a>