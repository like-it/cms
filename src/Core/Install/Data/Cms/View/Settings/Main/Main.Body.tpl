{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'main',
'command' => 'main',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Main/Module/Main.js')}}
{{/script}}