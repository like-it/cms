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
            <i class="{{
            __(
            $__.module +
            '.' +
            $__.submodule +
            '.section.' +
            $__.command +
            '.component.html.dropdown.addons.icon'
            )}}"></i>
        </button>
        <div
            class="dropdown-menu"
        >
            {{for.each($addons as $add)}}
            {{$require.basename = $add|uppercase.first.sentence:'.'}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Add/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </div>
    </div>
</div>