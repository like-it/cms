{R3M}
{{$section.name = 'main-content'}}
{{$section.title = 'Main-content'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
<section name="{{$section.name}}" class="col-10">
    <div class="h-100">
        <div class="card h-100 overflow-auto">
            {{script('module')}}
            {{require($controller.dir.view + $controller.title + '/Module/Email.Menu.js')}}
            {{/script}}
            {{require($controller.dir.view + $controller.title + '/Section/Email/Menu/Header.tpl')}}
            /*
            {{require($controller.dir.view + $controller.title + '/Section/Email/Main/Body.tpl')}}
            */
        </div>
    </div>
</section>