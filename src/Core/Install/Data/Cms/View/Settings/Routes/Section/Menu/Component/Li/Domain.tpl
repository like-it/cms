{{R3M}}
{{$section = 'domain'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$node = 'body'}}
<li class="nav-item nav-item-domain" data-url="{{server.url('core')}}Settings/Domains/Settings/">
    <div class="dropdown">
        <input type="hidden" name="node.domain" value="uuid" />
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
            Loading...
        </button>
        <ul class="dropdown-menu">
        </ul>
    </div>
</li>