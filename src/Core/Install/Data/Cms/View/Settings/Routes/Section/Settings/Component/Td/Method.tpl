{{R3M}}
<td>
    {{if(is.array($node.route.method))}}
        {{for.each($node.route.method as $method)}}
            <span class="method method-{{$method|lowercase}}">{{$method}}</span>
        {{/for.each}}
    {{/if}}
</td>