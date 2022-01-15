{{R3M}}
{{$section = 'domain'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$node = 'body'}}
<li class="nav-item">
    <div class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
            www.funda.world
        </button>
        <ul class="dropdown-menu">
            <li><span class="dropdown-item-text disabled">cms.funda.world</span></li>
            <li><span class="dropdown-item-text disabled">core.funda.world</span></li>
            <li><span class="dropdown-item-text">www.funda.world</span></li>
        </ul>
    </div>
</li>