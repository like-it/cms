{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Logs/And/Errors/Log/Module/Access.js')}}
{{/script}}
{{$request.method = 'replace-with'}}
{{$request.target = 'section[name="main-content"] .card-body'}}
{{require($controller.dir.view + $controller.title + '/Logs/And/Errors/Log/Section/Access.tpl')}}