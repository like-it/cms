{R3M}
{{$route = 'settings-components-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.components.class')}}
{{$link = __('settings.link.components')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}