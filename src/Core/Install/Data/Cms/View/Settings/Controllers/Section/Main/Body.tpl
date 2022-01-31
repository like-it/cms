{{R3M}}
{{if(
    $command === 'main' &&
    $subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-Content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-' + $command + '-' + $subcommand}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{$require.basename = 'Card.Body.' + $command|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Html/' + $require.basename + '.tpl')}}
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
{{/script}}