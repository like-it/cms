{R3M}
{{$a.name = 'main'}}
{{$a.translation = $a.name|replace:'-':'.'}}
{{$a.class = 'nav-link active'}}
{{$a.attribute = 'aria-current="true"'}}
{{$a.route = 'settings-import-' + $a.name}}
{{$a.data.url = ''}}
{{$a.data.frontend.url = route.get(route.prefix() + '-' + $a.route)}}
{{$a.link = __('settings.import.component.header.a.' + $a.translation +'.link')}}
<li class="nav-item">
    {{require($controller.dir.view + $controller.title + '/Import/Element/A/Nav.Link.tpl')}}
</li>