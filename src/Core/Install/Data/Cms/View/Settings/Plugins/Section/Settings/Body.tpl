{{R3M}}
{{if(
    $command === 'settings' &&
    $subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-' + $subcommand + '-' + $command}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{require($prefix + $require.submodule + '/Section/' + $require.command + '/Content.tpl')}}
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
{{/script}}