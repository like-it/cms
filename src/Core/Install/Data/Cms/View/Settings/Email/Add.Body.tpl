{R3M}
{{response.view([
'module' => $controller.name,
'submodule' => 'email',
'command' => 'add-body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
'is_add_body' => true,
'request' => $request
])}}
