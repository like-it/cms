{R3M}
{{$route = 'settings-controllers-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.controllers.class')}}
{{$link = __('settings.link.controllers')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}