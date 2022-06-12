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
            <i class="
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'dropdown' +
            '.' +
            'button' +
            '.' +
            'addons' +
            '.' +
            'icon'
            )}}"></i>
        </button>
        <div
            class="dropdown-menu"
        >
            {{for.each($addons as $add)}}
            {{$require.basename = $add|uppercase.first.sentence:'.'}}
            {{require($controller.dir.component + $require.module + '/Settings/Add/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </div>
    </div>
</div>