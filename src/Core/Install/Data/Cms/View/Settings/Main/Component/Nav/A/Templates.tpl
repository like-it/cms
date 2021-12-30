{R3M}
{{$route = 'settings-templates-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.templates.class')}}
{{$link = __('settings.link.templates')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}