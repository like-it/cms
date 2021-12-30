{R3M}
{{$a.name = 'account-settings'}}
{{$a.translation = $name|replace:'-':'.'}}
{{$a.url = server.url('core') + 'Settings/Body/'}}
{{$a.route = 'settings-body'}}
{{$a.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.class = __('settings.main.component.nav.a.' + $a.translation +'.class')}}
{{$a.link = __('settings.main.component.nav.a.' + $a.translation + '.link')}}
{{$a.is.active = ''}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}