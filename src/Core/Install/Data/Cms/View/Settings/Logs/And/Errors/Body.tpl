{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{$request.method = 'replace-with'}
{$request.target = 'section[name="main-content"] .card-body'}
{{require($controller.dir.view + $controller.title + '/Logs/And/Errors/Section/Body.tpl')}}