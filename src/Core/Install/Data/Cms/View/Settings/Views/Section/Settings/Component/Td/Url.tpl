{{R3M}}
<td title="{{$node.url}}">
    {{if(string.occurrence.case.insensitive($node.url, 'component') !== false)}}
    {{$node.dir.view = Execute:Node:host.dir($node.domain) + 'Component/'}}
    {{else}}
    {{$node.dir.view = Execute:Node:host.dir($node.domain) + 'View/'}}
    {{/if}}
    {{$node.url|replace:$node.dir.view:''}}
</td>