{{R3M}}
{{if(is.empty(cookie('test')))}}
{{redirect('https://google.com')}}
{{else}}
{{d(cookie('test'))}}
{{d(session())}}
{{dd('{{$this}}')}}
{{/if}}

{{response.view([
'module' => $controller.name,
'submodule' => 'components',
'command' => 'settings',
'subcommand' => 'body',
'init' => true,
'prefix' => $controller.dir.view + $controller.title + '/',
])}}