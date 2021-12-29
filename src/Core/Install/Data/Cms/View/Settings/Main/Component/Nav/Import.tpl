{R3M}
{{$route = 'settings-import'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.import.class')}}
{{$link = __('settings.link.import')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}