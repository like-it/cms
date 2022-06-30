{{R3M}}
{{d(session())}}
{{d(cookie('test'))}}
{{dd('{{$this}}')}}
{{response.view([
'module' => $controller.name,
'submodule' => 'components',
'command' => 'settings',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}