{R3M}
{{$a.name = 'routes'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.url = ''}}
{{$a.route = 'settings-' + $a.name + '-main'}}
{{$a.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.icon.class = __('settings.main.component.nav.a.' + $a.translation +'.icon.class')}}
{{$a.link = __('settings.main.component.nav.a.' + $a.translation + '.link')}}
{{$a.class = 'nav-link'}}
{{require($controller.dir.view + $controller.title + '/Main/Element/A/Nav.Link.tpl')}}
