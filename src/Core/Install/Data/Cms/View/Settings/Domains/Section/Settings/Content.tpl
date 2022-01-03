{{R3M}}
{{dd('$this')}}
{{if(
    $command === 'settings' &&
    $subcommand === 'content'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-settings'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
<div class="card-body h-100 card-body-{{$command}}">
{{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Table/Table.tpl', [])}}
</div>
{{script('module')}}
    {{require($prefix + '/Domains/Module/' + $require.command + '.js', [])}}
{{/script}}