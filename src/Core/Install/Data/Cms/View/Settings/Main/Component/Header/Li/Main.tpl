{R3M}
{{$a.name = 'main'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.class = 'nav-link'}}
{{$a.route = 'settings-' + $a.name + '-main-body'}}
{{$a.data.url = ''}}
{{$a.data.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.link = __('settings.main.component.header.a.' + $a.translation +'.link')}}
{{require($controller.dir.view + $controller.title + '/Main/Component/Li/Nav.Item.tpl')}}