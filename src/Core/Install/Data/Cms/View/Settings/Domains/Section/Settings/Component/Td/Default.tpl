{{R3M}}
<td class="text-end">
    {{if(!is.empty($node.isDefault))}}
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
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-is-default"
        title="{{$i.title}}"
    >
    </i>
    {{/if}}
</td>