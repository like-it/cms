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
<div class="card-body h-100 card-body-settings">
{{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Component/Table/Table.tpl', [])}}
</div>
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Email/Module/Settings.js')}}
{{/script}}