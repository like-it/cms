{R3M}
{$url = server.url('core')}} + 'Settings/Body/'}}
{{$route = 'settings-body'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.main.class')}}
{{$link = __('settings.link.main')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}