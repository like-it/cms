{{R3M}}
{{$option = 'default'}}
<td class="text-end">
    {{if(is.empty($node.is.installed))}}
        {{$require.basename = $option|uppercase.first.sentence:'.'}}
        {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Options/' + $require.basename + '.tpl')}}
        {{/for.each}}
    {{/if}}
</td>