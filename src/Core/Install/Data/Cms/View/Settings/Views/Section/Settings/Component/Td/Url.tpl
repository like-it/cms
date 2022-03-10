{{R3M}}
<td>
    {{dd(node.host.dir($node.domain))}}
    {{$node.url|replace:node.host.dir($node.domain):'/'}}
</td>