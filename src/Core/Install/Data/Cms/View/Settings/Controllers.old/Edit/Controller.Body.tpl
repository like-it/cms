{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'controllers',
'command' => 'edit-controller',
"subcommand" => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}