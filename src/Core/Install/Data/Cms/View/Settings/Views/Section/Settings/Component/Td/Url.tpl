{{R3M}}
<td title="{{$node.url}}">
    {{$namespace = 'Host.' + host.subdomain() + '.' + host.domain() + '.' + host.extension()}}
    {{$node.dir.view = $namespace:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>