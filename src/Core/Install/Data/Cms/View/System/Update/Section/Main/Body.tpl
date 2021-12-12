{R3M}
{{if($request.error)}}
{{/if}}
{{if($is.update.body)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-update'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Update/Module/Update.js')}}
{{/script}}
<div class="card-body h-100 card-body-update" data-menu=".system-update">
Update button and cli output....
</div>