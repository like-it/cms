{{R3M}}
<td>
    {{if(is.set($node.route.path))}}
        {{$node.route.path}}
    {{else}}
        {{$node.path}}
    {{/if}}
</td>