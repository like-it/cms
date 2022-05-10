{{R3M}}
<td title="{{$node.url}}">
    {{$function = 'Host.' +
    host.subdomain() +
    '.' +
    host.domain() +
    '.' +
    host.extension() +
    ':' +
    'Node' +
    ':' +
    'host.dir'
    }}
    {{$node.dir.view = $function($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>