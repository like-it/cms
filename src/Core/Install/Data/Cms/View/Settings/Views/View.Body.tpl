{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'views',
'command' => 'view',
"subcommand" => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}