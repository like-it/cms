{{R3M}}
<div class="dropdown dropup">
    <div class="btn-group">
        <button
            class="btn btn-outline-primary dropdown-toggle"
            type="button"
            data-toggle="dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            {{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.action.with.selected.text')}}
        </button>
        <div
            class="dropdown-menu"
        >
            {{for.each($actions as $action)}}
            {{$require.basename = $action|uppercase.first.sentence:'.'}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Action/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </div>
    </div>
</div>