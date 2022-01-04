{{R3M}}
{{if(
    $command === 'settings' &&
    $subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-settings'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{require($prefix + '/Domains/Section/' + $require.command + '/Component/Html/Card.Body.Settings.tpl')}}
{{script('module')}}
    {{require($prefix + '/Domains/Module/' + $require.command + '.js')}}
{{/script}}