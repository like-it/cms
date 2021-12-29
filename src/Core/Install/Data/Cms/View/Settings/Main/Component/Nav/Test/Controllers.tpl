{R3M}
{{$route = 'settings-controllers-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.controllers.class')}}
{{$link = __('settings.link.controllers')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}