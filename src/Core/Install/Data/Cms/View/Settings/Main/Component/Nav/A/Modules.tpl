{R3M}
{{$route = 'settings-modules-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.modules.class')}}
{{$link = __('settings.link.modules')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}