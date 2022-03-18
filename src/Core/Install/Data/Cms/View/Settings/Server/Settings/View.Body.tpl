{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'server-settings',
'command' => 'view',
"subcommand" => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}