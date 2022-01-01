{R3M}
{{$a.name = 'main'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.class = 'nav-link'}}
{{$a.route = 'settings-' + $a.name + '-body'}}
{{dd($a)}}
{{$a.data.url = ''}}
{{$a.data.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.link = __('settings.main.component.header.a.' + $a.translation +'.link')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/Li/Nav.Item.tpl')}}