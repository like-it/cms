{{R3M}}
{{if(
$command === 'add-template' &&
$subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-' + $command + '-body'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
<div class="card-body h-100 card-{{$command}}-body" data-menu=".{{$module}}-{{$submodule}}-{{$command}}">
{{require($prefix + $require.submodule + '/Section/Form/' + $require.command + '.tpl')}}
</div>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Add.js')}}
{{/script}}