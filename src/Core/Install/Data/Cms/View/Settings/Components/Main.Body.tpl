{{R3M}}
{{response.view([
'module' => $controller.name,
'submodule' => 'components',
'command' => 'main',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}