{R3M}
{{$route = 'settings-basic-site-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.basic_site_settings.class')}}
{{$link = __('settings.link.basic_site_settings')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}