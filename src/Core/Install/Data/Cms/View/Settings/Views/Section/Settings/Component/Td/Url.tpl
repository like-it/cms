{{R3M}}
<td title="{{$node.url}}">
    {{import('Host.Core.Funda.World:Node')}}
    {{$node.dir.view = Host.Core.Funda.World:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>