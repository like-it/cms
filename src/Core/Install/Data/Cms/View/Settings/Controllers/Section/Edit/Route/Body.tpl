{{R3M}}
{{if(
$command === 'edit-route' &&
$subcommand === 'body'
)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-' + $request.node.uuid}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
<div class="card-body h-100 card-body-{{$request.node.uuid}}">
{{require($prefix + $require.submodule + '/Section/Form/' + $require.command + '.tpl')}}
</div>
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Edit.js')}}
{{/script}}