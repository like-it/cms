{{R3M}}
<td title="{{$node.url}}">
    {{$node.dir.view = Core:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>