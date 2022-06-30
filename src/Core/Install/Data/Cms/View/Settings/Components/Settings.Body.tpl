{{R3M}}
{{dd('{{$this}}')}}
{{response.view([
'module' => $controller.name,
'submodule' => 'components',
'command' => 'settings',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}