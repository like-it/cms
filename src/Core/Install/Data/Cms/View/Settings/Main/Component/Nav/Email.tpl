{R3M}
{{$route = 'settings-email-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.email.class')}}
{{$link = __('settings.link.email')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}