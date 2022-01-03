{R3M}
{{$section.name = 'main-content'}}
{{$section.title = 'Main-content'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
{{dd('$this')}}
<section name="{{$section.name}}" class="col-12 col-md-10">
    <div class="h-100">
        <div class="card h-100 overflow-auto">
            {{require($controller.dir.view + $controller.title + '/Domains/Section/Menu/Header.tpl')}}
            {{require($controller.dir.view + $controller.title + '/Email/Section/Main/Body.tpl')}}
        </div>
    </div>
</section>