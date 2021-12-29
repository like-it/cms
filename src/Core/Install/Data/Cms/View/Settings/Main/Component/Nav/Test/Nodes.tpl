{R3m}
{{$route = 'settings-nodes-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.nodes.class')}}
{{$link = __('settings.link.nodes')}}
{{require($controller.dir.view + $controller.dir.title + '/Main/Element/A.tpl')}}
