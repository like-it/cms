{{R3M}}
<div class="card-body h-100 card-{{$command}}-body">
    {{markdown.read(
    $controller.dir.data +
    'Markdown' +
    '/' +
    $require.language +
    '/' +
    $require.module +
    '.' +
    $require.submodule +
    '.' +
    $require.command +
    '.md'
    )}}
</div>