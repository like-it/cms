{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'routes',
'command' => 'edit-redirect',
"subcommand" => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}