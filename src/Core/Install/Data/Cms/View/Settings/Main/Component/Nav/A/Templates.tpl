{R3M}
{{$a.name = 'templates'}}
{{$a.translation = $name|replace:'-':'.'}}
{{$a.url = ''}}
{{$a.route = 'settings-' + $a.name}}
{{$a.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.class = __('settings.main.component.nav.a.' + $a.translation +'.class')}}
{{$a.link = __('settings.main.component.nav.a.' + $a.translation + '.link')}}
{{$a.is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}