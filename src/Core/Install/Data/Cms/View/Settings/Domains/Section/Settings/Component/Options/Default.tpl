{R3M}
{{if(is.empty($node.is.default))}}
    {{$i.icon = __(
    $__.module +
    '.' +
    $__.submodule +
    '.section.' +
    $__.command +
    '.component.options.default.action.icon'
    )}}
    {{$i.title = __(
    $__.module +
    '.' +
    $__.submodule +
    '.section.' +
    $__.command +
    '.component.options.default.action.title'
    )}}
    {{$span.text = __(
    $__.module +
    '.' +
    $__.submodule +
    '.section.' +
    $__.command +
    '.component.options.default.action.text'
    )}}
    <a
        class="dropdown-item item-default"
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