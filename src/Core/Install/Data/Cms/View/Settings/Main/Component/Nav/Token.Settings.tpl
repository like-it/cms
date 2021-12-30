{R3M}
{{$route = 'settings-token-settings-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.token_settings.class')}}
{{$link = __('settings.link.token_settings')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}