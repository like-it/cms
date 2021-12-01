{R3M}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.section.body.body.title')}}</h5>
    <ul>
        {{$read = dir.read($controller.dir.view + $controller.title + '/Section/Body/Main/Li/')}}
        {{for.each($read as $nr => $file)}}
            {{require($file.url)}}
        {{/for.each}}
    </ul>
</div>