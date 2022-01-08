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
    <a
        class="dropdown-item"
    >
        <i
            class="{{$i.icon}} {{$module}}-{{$submodule}}-is-default"
            title="{{$i.title}}"
        >
        </i>
        <span>{{$span.text}}</span>
    </a>
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
    {{$span.text = __(
    $__.module +
    '.' +
    $__.submodule +
    '.section.' +
    $__.command +
    '.' +
    $__.subcommand +
    '.component.options.default.action.text'
    )}}
    <a
        class="dropdown-item"
        data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/Default/{{$node.uuid}}"
        data-request-method="POST"
    >
        <i
            class="{{$i.icon}} {{$module}}-{{$submodule}}-default-action"
            title="{{$i.title}}"
        >
        </i>
        <span>{{$span.text}}</span>
    </a>
{{/if}}