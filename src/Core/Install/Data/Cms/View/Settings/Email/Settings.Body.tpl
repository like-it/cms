{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'email',
'command' => 'settings-body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}