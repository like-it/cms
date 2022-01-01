{R3M}
{{$a.name = 'settings'}}
{{$a.route = 'settings-export-' + $a.name}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.class = 'nav-link'}}
{{$a.data.url = ''}}
{{$a.data.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.link = __('settings.export.component.header.a.' + $a.translation +'.link')}}
{{require($controller.dir.view + $controller.title + '/Import/Element/Li/Nav.Item.tpl')}}