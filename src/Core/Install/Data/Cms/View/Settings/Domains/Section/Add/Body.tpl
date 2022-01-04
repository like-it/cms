{{R3M}}
{{if(
$command === 'add' &&
$subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-' + $command}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
<div class="card-body h-100 card-body-{{$command}}" data-menu=".{{$module}}-{{$submodule}}-{{$command}}">
{{require($prefix + $require.module + '/Section/Form/' + $require.command + '.tpl')}}
</div>
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Email/Module/Add.js')}}
{{/script}}