{R3M}
{{$route = 'settings-style-sheets-and-elements-main'}}
{{$frontend.url = route.get(route.prefix() + '-' + $route)}}
{{$class = __('settings.icon.style_sheets_and_elements.class')}}
{{$link = __('settings.link.style_sheets_and_elements')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A.tpl')}}