{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'controllers',
'command' => 'settings',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}