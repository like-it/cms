{R3M}
{{$route = 'settings-mode-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.mode.class')}}
{{$link = __('settings.link.mode')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}