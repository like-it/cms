{R3M}
{{$route = 'settings-token-settings-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.token_settings.class')}}
{{$link = __('settings.link.token_settings')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}