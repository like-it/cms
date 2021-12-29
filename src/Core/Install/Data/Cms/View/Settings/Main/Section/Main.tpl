{R3M}
{{$section.name = 'main'}}
{{$section.title = 'Main'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
{{import($section.title +'.css')}}
<section name="{{$section.name}}">
    <div class="container mw-100 h-100">
        <div class="row h-100">
            {{require($controller.dir.view + $controller.title + '/Main/Section/Navigation.tpl')}}
            {{require($controller.dir.view + 'Loading/Section/Main/Content.tpl')}}
        </div>
    </div>
</section>
