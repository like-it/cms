{{R3M}}
{{if(
$command === 'view' &&
$subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-view-' + $request.node.uuid}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
<div class="card-body h-100 card-body-view-{{$request.node.key}}">
{{require($prefix + $require.submodule + '/Section/' + $require.command + '/' + $require.command + '.tpl')}}
</div>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
{{/script}}