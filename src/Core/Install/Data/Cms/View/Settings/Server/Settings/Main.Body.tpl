{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'server-settings',
'command' => 'main',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}