{{R3M}}
<td title="{{$node.url}}">
    {{$node.dir.view = Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>