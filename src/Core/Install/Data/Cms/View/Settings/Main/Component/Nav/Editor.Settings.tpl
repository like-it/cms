{R3M}
{{$url = server.url('core') + 'Settings/Body/'}}
{{$route = 'settings-body'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.editor_settings.class')}}
{{$link = __('settings.link.editor_settings')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}