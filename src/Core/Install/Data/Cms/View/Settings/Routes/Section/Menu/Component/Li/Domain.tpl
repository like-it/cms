{{R3M}}
{{$section = 'domains-settings'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
<li class="nav-item nav-item-domain" data-url="{{server.url('core')}}{{$require.module}}/{{$require.section}}/">
    <div class="dropdown">
        <input type="hidden" name="node.domain" value="uuid" />
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
            Loading...
            {{__(
            $__.module +
            '.' +
            $__.submodule +
            '.component.header.button.' +
            $__.section +
            '.' +
            'link'
            )}}
        </button>
        <ul class="dropdown-menu">
        </ul>
    </div>
</li>