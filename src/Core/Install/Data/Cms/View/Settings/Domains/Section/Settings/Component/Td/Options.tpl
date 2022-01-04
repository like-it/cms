{R3M}
<td class="text-end">
    {{for.each($options as $option)}}
        {{$require.basename = $option|uppercase.first.sentence:'.'}}
        {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Options/' + $require.basename + '.tpl')}}
    {{/for.each}}
</td>