{R3m}
{{$route = 'settings-templates-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.templates.class')}}
{{$link = __('settings.link.templates')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}