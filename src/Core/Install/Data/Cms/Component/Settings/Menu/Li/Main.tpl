{{R3M}}
{{$section = 'main'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$node = 'body'}}
<li class="nav-item">
    <a
        class="nav-link active {{$module}}-{{$submodule}}-{{$section}}"
        data-frontend-url="{{
        route.get(
        route.prefix() +
        '-' +
        $module +
        '-' +
        $submodule +
        '-' +
        $section +
        '-' +
        $node
        )}}"
        data-selected=".card-body-{{$section}}"
    >
        {{__(
        'component' +
        '.' +
        $__.module +
        '.' +
        'menu' +
        '.' +
        'li' +
        '.' +
        $__.section +
        '.' +
        'title'
        )}}
    </a>
</li>