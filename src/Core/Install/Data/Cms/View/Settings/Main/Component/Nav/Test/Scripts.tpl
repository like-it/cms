{R3m}
{{$route = 'settings-scripts-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.scripts.class')}}
{{$link = __('settings.link.scripts')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}
