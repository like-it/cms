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
{{if(!is.empty($a.url))
    <a
        class="{{$a.class}}"
        {{$a.attribute}}
        data-url="{{$a.data.url}}"
        data-frontend-url="{{$a.data.frontend.url}}"
    >
        {{$a.link}}
    </a>
{{else}}
    <a
        class="{{$a.class}}"
        {{$a.attribute}}
        data-frontend-url="{{$a.data.frontend.url}}"
    >
        {{$a.link}}
    </a>
{{/if}}
</li>