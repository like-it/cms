{{R3M}}
<td title="{{$node.url}}">
    {{$node.dir.view = Execute:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>