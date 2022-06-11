{{R3M}}
{{$section = 'domains-settings'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
<li class="nav-item nav-item-domain" data-url="{{server.url('core')}}{{$require.module}}/{{$require.section}}/">
    <div class="dropdown">
        <input type="hidden" name="node.domain" value="uuid" />
        <button type="button" class="btn btn-secondary dropdown-toggle {{$section}}" data-bs-toggle="dropdown">
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'menu' +
            '.' +
            'button' +
            '.' +
            $__.section +
            '.' +
            'title'
            )}}
        </button>
        <ul class="dropdown-menu">
        </ul>
    </div>
</li>