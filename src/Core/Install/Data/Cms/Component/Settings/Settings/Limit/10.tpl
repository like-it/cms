{{R3M}}
{{$span.text = 10}}
<a
    class="dropdown-item list-limit"
    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/{node.domain}/?limit=10&&filter[type]={{$request.filter.type}}"
    data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' $command + '-body')}}"
>
<span>{{$span.text}}</span>
</a>