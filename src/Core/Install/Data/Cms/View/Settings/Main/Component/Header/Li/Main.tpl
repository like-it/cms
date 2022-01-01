{R3M}
{{$a.name = 'main'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.class = 'nav-link'}}
{{$a.route = 'settings-main-' + $a.name}}
{{$a.data.url = ''}}
{{$a.data.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.link = __('settings.import.component.header.a.' + $a.translation +'.link')}}
{{require($controller.dir.view + $controller.title + '/Import/Element/Li/Nav.Item.tpl')}}