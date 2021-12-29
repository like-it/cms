{R3M}
{{$route = 'settings-scripts-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.scripts.class')}}
{{$link = __('settings.link.scripts')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}
