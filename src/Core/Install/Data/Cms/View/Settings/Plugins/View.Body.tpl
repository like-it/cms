{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'plugins',
'command' => 'view',
"subcommand" => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}