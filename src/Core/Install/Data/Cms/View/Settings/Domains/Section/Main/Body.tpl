{R3M}
{{if($command === 'main.body')}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-Content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-main'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($prefix + $require.submodule + '/Module/Main.js')}}
{{/script}}
<div class="card-body h-100 card-body-main">
    <h5 class="card-title">{{__('settings.email.section.main.body.title')}}</h5>
    <p class="card-text">{{implode("<br>\n", __('settings.email.section.main.body.text'))}}</p>
</div>