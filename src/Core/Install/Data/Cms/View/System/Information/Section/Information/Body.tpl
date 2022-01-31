{{R3M}}
{{if($is.information.body)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-information'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Information/Module/Information.js')}}
{{/script}}
<div class="card-body h-100 card-body-information">
    <h5 class="card-title">{{__('system.information.section.information.body.title')}}</h5>
    <p class="card-text">{{implode("\n<br>", __('system.information.section.information.body.text'))}}</p>
</div>