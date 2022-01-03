{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'domains',
'command' => 'settings',
'subcommand' => 'body',
'init' => true,
'debug' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}