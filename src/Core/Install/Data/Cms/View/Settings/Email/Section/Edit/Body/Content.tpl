{R3M}
{{if($command === 'edit-body')}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-' + $request.node.uuid}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Email/Module/Edit.js')}}
{{/script}}
<div class="card-body h-100 card-body-{{$request.node.uuid}}">
{{require($controller.dir.view + $controller.title + '/Email/Section/Form/Edit.tpl', [])}}
</div>