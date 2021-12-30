{R3M}
{{$route = 'settings-scripts-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.scripts.class')}}
{{$link = __('settings.link.scripts')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}
