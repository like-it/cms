{R3M}
{{response.view([
'init' => true,
'module' => true,
'submodule' => 'export',
'command' => 'main',
'prefix' => $controller.dir.view + $controller.title + '/',
])}}
/*
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Export/Module/Main.js')}}
{{/script}}
{{require($controller.dir.view + $controller.title + '/Export/Section/Main/Content.tpl')}}
*/