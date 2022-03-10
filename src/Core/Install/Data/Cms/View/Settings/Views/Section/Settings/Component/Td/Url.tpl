{{R3M}}
<td>
    {{$node.dir.view = node.host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:'/'}}
</td>