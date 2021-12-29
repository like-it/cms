{R3m}
{{$route = 'settings-mode-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.mode.class')}}
{{$link = __('settings.link.mode')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}