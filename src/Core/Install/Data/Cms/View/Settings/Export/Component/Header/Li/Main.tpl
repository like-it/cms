{{R3M}}
{{$a.name = 'main'}}
{{$a.route = 'settings-export-' + $a.name}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.class = 'nav-link'}}
{{$a.data.url = ''}}
{{$a.data.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.link = __('settings.export.component.header.a.' + $a.translation +'.link')}}
<li class="nav-item">
    {{require($controller.dir.view + $controller.title + '/Export/Component/Header/A/Nav.Link.tpl')}}
</li>