{R3M}
{{$url = server.url('core') + 'Settings/Body/'}}
{{$route = 'settings-body'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.main.class')}}
{{$link = __('settings.link.main')}}
{{$is.active = 'active'}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}