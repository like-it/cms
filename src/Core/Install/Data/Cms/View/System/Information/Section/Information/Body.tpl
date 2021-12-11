{R3M}
{{if($is.main.body)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-main'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Information/Module/Information.js')}}
{{/script}}
<div class="card-body h-100 card-body-information">
    <h5 class="card-title">{{__('settings.section.email.main.body.title')}}</h5>
    <p class="card-text">{{__('settings.section.email.main.body.text')}}</p>
</div>