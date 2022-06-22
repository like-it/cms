{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'plugins',
'command' => 'main',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}