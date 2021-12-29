{R3m}
{{$route = 'settings-export'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.export.class')}}
{{$link = __('settings.link.export')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}