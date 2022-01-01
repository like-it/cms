{R3M}
{{$a.name = 'main'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.url = server.url('core') + 'Settings/Body/'}}
{{$a.route = 'settings-' + $a.name + '-body'}}
{{$a.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.icon.class = __('settings.main.component.nav.a.' + $a.translation +'.icon.class')}}
{{$a.link = __('settings.main.component.nav.a.' + $a.translation + '.link')}}
{{$a.class = 'nav-link active'}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}