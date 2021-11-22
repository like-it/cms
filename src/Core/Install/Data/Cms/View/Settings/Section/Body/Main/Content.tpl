{{$section.name = 'main-content'}}
{{$section.title = 'Main-content'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
<section name="main-content" class="col-10">
    <div class="h-100">
        <div class="card h-100 overflow-auto">

        </div>
    </div>
</section>