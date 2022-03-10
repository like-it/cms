{{R3M}}
<td>
    {{$node.host.dir = node.host.dir($node.domain)}}
    {{$node.url|replace:$node.host.dir:'/'}}
</td>