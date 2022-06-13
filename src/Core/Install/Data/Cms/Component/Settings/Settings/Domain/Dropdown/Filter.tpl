{{R3M}}
<div class="dropdown dropup">
    <div class="btn-group">
        <button
            class="btn btn-outline-primary dropdown-toggle filter-type"
            type="button"
            data-toggle="dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            {{if($request.filter.type==='All')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'all' +
            '.' +
            'text'
            )}}
            {{elseif($request.filter.type==='File')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'file' +
            '.' +
            'text'
            )}}
            {{elseif($request.filter.type==='Dir')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'dir' +
            '.' +
            'text'
            )}}
            {{elseif($request.filter.extension==='tpl')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'tpl' +
            '.' +
            'text'
            )}}
            {{elseif($request.filter.extension==='css')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'css' +
            '.' +
            'text'
            )}}
            {{elseif($request.filter.extension==='js')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'js' +
            '.' +
            'text'
            )}}
            {{elseif($request.filter.extension==='json')}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'json' +
            '.' +
            'text'
            )}}
            {{else}}
            {{__(
            'component' +
            '.' +
            $__.module +
            '.' +
            'settings' +
            '.' +
            'filter' +
            '.' +
            'file' +
            '.' +
            'text'
            )}}
            {{/if}}
        </button>
        <div
            class="dropdown-menu"
        >
            {{for.each($filters as $filter)}}
            {{$require.basename = $filter|uppercase.first.sentence:'.'}}
            {{require($controller.dir.component + $require.module + '/Settings/Filter/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </div>
    </div>
</div>