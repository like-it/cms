{{R3M}}
<td>
    <strong>
        {{__(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.' +
        $__.subcommand +
        '.component.thead.' +
        'method'
        )}}
    </strong>
</td>
<td colspan="2">
    {{for.each($node.route.method as $method)}}
    <span class="method method-{{$method}}">{{$method}}</span>
    {{/for.each}}
</td>