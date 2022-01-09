{{R3M}}
<td class="text-end">
    {{if(is.empty($node.is.installed))}}
        {{$i.icon = __(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.' +
        $__.subcommand +
        '.component.options.default.icon'
        )}}
        {{$i.title = __(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.' +
        $__.subcommand +
        '.component.options.default.title'
        )}}
        {{$span.text = __(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.' +
        $__.subcommand +
        '.component.options.default.text'
        )}}
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-is-default"
        title="{{$i.title}}"
    >
    </i>
    {{/if}}
</td>