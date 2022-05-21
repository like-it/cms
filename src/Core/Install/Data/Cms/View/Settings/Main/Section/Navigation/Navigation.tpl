{{R3M}}
{{$categories = [
'General',
'Domain',
'Server'
]}}
<section name="main-navigation" class="col-12 col-md-2">
    <div class="">
        <nav class="nav flex-column">
            {{for.each($categories as $category)}}
                {{$read = dir.read($controller.dir.view + $controller.title + '/Main/Component/Nav/A/'+ $category + '/')}}
                {{$read = sort($read, ["url" => "asc"])}}
                <h3>{{$category}}</h3><br>
                {{for.each($read as $nr => $file)}}
                {{require($file.url)}}
                {{/for.each}}
            {{/for.each}}
        </nav>
    </div>
</section>