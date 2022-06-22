{{R3M}}
{{$section.name = 'main-content'}}
{{$section.title = 'Main-Content'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
<section name="{{$section.name}}" class="col-12 col-md-10 {{$module}}-{{$submodule}}">
    <div class="h-100">
        <div class="card h-100 overflow-auto">
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Menu.tpl')}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Body.tpl')}}
        </div>
    </div>
</section>