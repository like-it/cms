{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'export',
'command' => 'main',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}