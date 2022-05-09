{{R3M}}
<td title="{{$node.url}}">
    {{$node.dir.view = Source:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>