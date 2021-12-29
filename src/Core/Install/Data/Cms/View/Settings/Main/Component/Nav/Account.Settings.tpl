{R3M}
{{$url = server.url('core') + 'Settings/Body/'}}
{{$route = 'settings-body'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.account_settings.class')}}
{{$link = __('settings.link.account_settings')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}