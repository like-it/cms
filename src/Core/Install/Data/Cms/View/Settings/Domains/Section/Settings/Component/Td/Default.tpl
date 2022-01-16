{{R3M}}
<td class="text-end">
    {{if(!is.empty($node.is.default))}}
        {{$i.icon = __(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.component.options.default.icon'
        )}}
        {{$i.title = __(
        $__.module +
        '.' +
        $__.submodule +
        '.section.' +
        $__.command +
        '.component.options.default.title'
        )}}
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-is-default"
        title="{{$i.title}}"
    >
    </i>
    {{/if}}
</td>