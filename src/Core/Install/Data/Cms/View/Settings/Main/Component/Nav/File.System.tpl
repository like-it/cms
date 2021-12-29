{R3M}
{{$route = 'settings-file-system'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.file_system.class')}}
{{$link = __('settings.link.file_system')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}