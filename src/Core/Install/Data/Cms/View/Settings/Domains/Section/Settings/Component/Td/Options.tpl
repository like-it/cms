{{R3M}}
<td class="text-end">
    {{if(is.empty($node.is.installed))}}
        <div class="dropdown dropstart">
            <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                data-toggle="dropdown"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                {{__('settings.domains.section.settings.component.td.options.text')}}
            </button>
            <div
                class="dropdown-menu"
            >
                {{for.each($options as $option)}}
                    {{$require.basename = $option|uppercase.first.sentence:'.'}}
                    {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Options/' + $require.basename + '.tpl')}}
                {{/for.each}}
            </div>
        </div>
    {{/if}}

</td>