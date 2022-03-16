{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'server-settings',
'command' => 'main',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}