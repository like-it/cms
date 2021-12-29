{R3M}
{{$route = 'settings-routes-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.routes.class')}}
{{$link = __('settings.link.routes')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}
