{{R3M}}
<div class="dropdown dropup col-lg-12">
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
            $__.module +
            '.' +
            $__.submodule +
            '.section.' +
            $__.command +
            '.component.filter.all.text'
            )}}
            {{elseif($request.filter.type==='File')}}
            {{__(
            $__.module +
            '.' +
            $__.submodule +
            '.section.' +
            $__.command +
            '.component.filter.file.text'
            )}}
            {{elseif($request.filter.type==='Dir')}}
            {{__(
            $__.module +
            '.' +
            $__.submodule +
            '.section.' +
            $__.command +
            '.component.filter.dir.text'
            )}}
            {{else}}
            {{__(
            $__.module +
            '.' +
            $__.submodule +
            '.section.' +
            $__.command +
            '.component.filter.file.text'
            )}}
            {{/if}}
        </button>
        <div
            class="dropdown-menu"
        >
            {{for.each($filters as $filter)}}
            {{$require.basename = $filter|uppercase.first.sentence:'.'}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Filter/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </div>
    </div>
</div>