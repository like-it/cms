{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'export',
'command' => 'settings',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}