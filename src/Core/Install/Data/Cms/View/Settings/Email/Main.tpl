{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'email',
'command' => 'main',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}