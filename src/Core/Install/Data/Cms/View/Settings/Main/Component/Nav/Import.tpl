{R3m}
{{$route = 'settings-import'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.import.class')}}
{{$link = __('settings.link.import')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}