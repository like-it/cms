{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'domains',
'command' => 'add-body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}
