{R3M}
{{$route = 'settings-export'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.export.class')}}
{{$link = __('settings.link.export')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}