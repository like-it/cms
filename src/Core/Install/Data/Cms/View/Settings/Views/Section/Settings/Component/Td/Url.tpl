{{R3M}}
{{import('Host.Core.Funda.World:Node')}}
<td title="{{$node.url}}">
    {{$node.dir.view = Host.Core.Funda.World:Node:host.dir($node.domain) + 'View/'}}
    {{$node.url|replace:$node.dir.view:''}}
</td>