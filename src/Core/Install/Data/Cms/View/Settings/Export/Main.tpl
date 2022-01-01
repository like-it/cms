{R3M}
{{response.view([
'init' => true,
'script.module' => true,
'module' => $controller.name,
'submodule' => 'export',
'command' => 'main',
'prefix' => $controller.dir.view + $controller.title + '/',
])}}