{{R3M}}
{{$section = 'domain'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$node = 'body'}}
<li class="nav-item">
    <div class="dropdown">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
            www.funda.world
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item disabled" href="#">cms.funda.world</a></li>
            <li><a class="dropdown-item disabled" href="#">core.funda.world</a></li>
            <li><a class="dropdown-item active" href="#">www.funda.world</a></li>
        </ul>
    </div>
</li>