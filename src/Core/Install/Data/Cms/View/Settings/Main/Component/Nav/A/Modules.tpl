{R3M}
{{$a.name = 'modules'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.url = ''}}
{{$a.route = 'settings-' + $a.name + '-main'}}
{{$a.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.class = __('settings.main.component.nav.a.' + $a.translation +'.class')}}
{{$a.link = __('settings.main.component.nav.a.' + $a.translation + '.link')}}
{{$a.is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}