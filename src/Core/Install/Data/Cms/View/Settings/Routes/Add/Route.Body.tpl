{{R3M}}
{{$prefix = $controller.dir.view + $controller.title + '/'}}
{{require($prefix + 'Init.tpl')}}
{{$module = $controller.name}}
{{$submodule = 'routes'}}
{{$command = 'add-route'}}
{{$subcommand = 'body'}}
{{if(is.empty($subcommand))}}
{{$subcommand = 'content'}}
{{/if}}
{{$__.module = $module|lowercase|replace:'-':'.'}}
{{$__.submodule = $submodule|lowercase|replace:'-':'.'}}
{{$__.command = $command|lowercase|replace:'-':'.'}}
{{$__.subcommand = $subcommand|lowercase|replace:'-':'.'}}
{{$require.module = $module|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.command = $command|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.subcommand = $subcommand|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{if(
$command === 'add-route' &&
$subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-' + $command}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
<div class="card-body h-100 card-body-{{$command}}" data-menu=".{{$module}}-{{$submodule}}-{{$command}}">
{{require($prefix + $require.submodule + '/Section/Form/' + $require.command + '.tpl')}}
</div>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Add.js')}}
{{/script}}