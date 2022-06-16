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
            'action' +
            '.' +
            'text'
            )}}
        </button>
        <div
            class="dropdown-menu"
        >
            {{if(is.array($actions))}}
            {{for.each($actions as $action)}}
            {{$require.basename = $action|uppercase.first.sentence:'.'}}
            {{require($controller.dir.component + $require.module + '/Settings/Domain/Action/' + $require.basename + '.tpl')}}
            {{/for.each}}
            {{/if}}
        </div>
    </div>
</div>