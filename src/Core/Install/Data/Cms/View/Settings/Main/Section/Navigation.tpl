{R3m}
<section name="main-navigation" class="col-12 col-md-2">
    <div class="">
        <nav class="nav flex-column">
            {{$read = dir.read($controller.dir.view + $controller.title + '/Main/Component/Nav/')}}
            {{$read = sort($read, ["url" => "asc"])}}
            {{for.each($read as $nr => $file)}}
            {{require($file.url)}}
            {{/for.each}}
        </nav>
    </div>
</section>