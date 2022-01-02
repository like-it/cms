{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'email',
'command' => 'add-body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
'is.add.body' => true,
'request' => $request
])}}
