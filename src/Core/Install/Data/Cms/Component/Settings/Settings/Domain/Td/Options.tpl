{{R3M}}
<td class="text-end">
    {{if(!is.empty($node.domain))}}
        <div class="dropdown dropstart">
            <button
                class="btn btn-secondary dropdown-toggle"
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
                'td' +
                '.' +
                'options' +
                '.' +
                'text'
                )}}
            </button>
            <div
                class="dropdown-menu"
            >
                {{for.each($options as $option)}}
                    {{$require.basename = $option|uppercase.first.sentence:'.'}}
                    {{require($controller.dir.component + $require.module + '/Settings/Domain/Options/' + $require.basename + '.tpl')}}
                {{/for.each}}
            </div>
        </div>
    {{/if}}

</td>