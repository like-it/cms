{{R3M}}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.section.body.title')}}</h5>
    <ul>
        {{$read = dir.read($controller.dir.view + $controller.title + '/Main/Component/Body/Li/')}}
        {{$read = sort($read, ["url" => "asc"])}}
        {{for.each($read as $nr => $file)}}
            {{require($file.url)}}
        {{/for.each}}
    </ul>
</div>