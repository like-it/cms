{{R3M}}
<td>
    <strong>
        {{__(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.component.thead.' +
        'method'
        )}}
    </strong>
</td>
<td colspan="2">
    {{if(is.array($node.route.method))}}
        {{for.each($node.route.method as $method)}}
            <span class="method method-{{$method}}">{{$method}}</span>
        {{/for.each}}
    {{/if}}
</td>