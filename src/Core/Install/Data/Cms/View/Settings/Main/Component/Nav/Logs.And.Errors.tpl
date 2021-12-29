{R3M}
{{$route = 'settings-logs-and-errors-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.logs_and_errors.class')}}
{{$link = __('settings.link.logs_and_errors')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}