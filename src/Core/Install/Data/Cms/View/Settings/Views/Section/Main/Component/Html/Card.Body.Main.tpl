{{R3M}}
<div class="card-body h-100 card-{{$command}}-body">
    {{dd('{{$this}}')}}
    {{markdown.read(
    $prefix +
    $require.submodule +
    '/Section/' +
    $require.command +
    '/Component/Markdown/' +
    $require.language +
    '/' +
    $require.submodule +
    '.md'
    )}}
</div>