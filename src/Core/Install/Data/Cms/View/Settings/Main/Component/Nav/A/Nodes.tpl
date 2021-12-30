{R3M}
{{$route = 'settings-nodes-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.nodes.class')}}
{{$link = __('settings.link.nodes')}}
{{$is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}
