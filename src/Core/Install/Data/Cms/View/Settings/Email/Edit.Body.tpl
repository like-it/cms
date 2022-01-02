{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'email',
'command' => 'edit-body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
'is.edit.body' => true
])}}