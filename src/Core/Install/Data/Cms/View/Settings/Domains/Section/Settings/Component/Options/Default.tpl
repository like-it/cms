{R3M}
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
        class="{{$i.icon}} {{$module}}-{{$submodule}}-{{$command}}-is-default"
        title="{{$i.title}}"
    >
    </i>
{{else}}
    {{$i.icon = __(
    $__.module +
    '.' +
    $__.submodule +
    '.section.' +
    $__.command +
    '.' +
    $__.subcommand +
    '.component.options.default.action.icon'
    )}}
    {{$i.title = __(
    $__.module +
    '.' +
    $__.submodule +
    '.section.' +
    $__.command +
    '.' +
    $__.subcommand +
    '.component.options.default.action.title'
    )}}
    <i
        class="{{$i.icon}} {{$module}}-{{$submodule}}-default-action"
        title="{{$i.title}}"
        data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Default/{{$node.uuid}}"
        data-request-method="POST"
    >
    </i>
{{/if}}