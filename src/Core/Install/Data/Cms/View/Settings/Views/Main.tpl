{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'views',
'command' => 'main',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}