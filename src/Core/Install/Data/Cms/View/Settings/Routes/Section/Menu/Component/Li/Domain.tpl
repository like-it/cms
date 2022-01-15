{{R3M}}
{{$section = 'domain'}}
{{$__.section = $section|lowercase|replace:'-':'.'}}
{{$require.section = $section|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$node = 'body'}}
<li class="nav-item">
    <select name="menu-domain" class="form-control">
        <option value="uuid">www.funda.world</option>
        <option value="uuid">test</option>
    </select>
</li>