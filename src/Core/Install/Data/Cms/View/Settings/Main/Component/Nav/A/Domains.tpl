{R3M}
{{$route = 'settings-domains-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.domains.class')}}
{{$link = __('settings.link.domains')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}