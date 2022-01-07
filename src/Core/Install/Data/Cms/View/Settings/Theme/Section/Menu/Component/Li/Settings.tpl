{{R3M}}
{{$section = 'settings'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{$node = 'body'}}
<li class="nav-item">
    <a
        class="nav-link {{$module}}-{{$submodule}}-{{$section}}"
        data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $section + '-' + $node)}}"
        data-selected=".card-body-{{$section}}"
    >
        {{__($__.module + '.' + $__.submodule + '.component.header.a.' + $__.section + '.' + 'link')}}
    </a>
</li>