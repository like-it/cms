{{R3M}}
<div class="card-body h-100 card-{{$command}}-body">
    {{markdown.read(
    $prefix +
    $require.submodule +
    '/Section/' +
    $require.command +
    '/Component/Markdown/' +
    $require.submodule +
    '.md'
    )}}
</div>