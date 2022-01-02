{R3M}
{{if($request.error)}}
{{/if}}
{{if($command === 'add-body')}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-add'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Email/Module/Add.js')}}
{{/script}}
<div class="card-body h-100 card-body-add" data-menu=".settings-email-add">
{{require($controller.dir.view + $controller.title + '/Email/Section/Form/Add.tpl', [])}}
</div>