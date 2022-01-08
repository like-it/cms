{{R3M}}
<td class="text-end">
    {{if(is.empty($node.is.installed)) && is.empty($is.test)}}
    {{$is.test = true}}
        <div class="dropdown">
            <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                Options
            </button>
            <div
                class="dropdown-menu"
                aria-labelledby="dropdownMenuButton"
            >
                {{for.each($options as $option)}}
                    {{$require.basename = $option|uppercase.first.sentence:'.'}}
                    {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Options/' + $require.basename + '.tpl')}}
                {{/for.each}}
            </div>
        </div>

    {{/if}}
</td>