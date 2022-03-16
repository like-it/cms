{{R3M}}
<div class="menu">
    {{require($prefix + $require.submodule + '/Section/Form/Component/Menu/' + $require.action + '.tpl')}}
</div>
<div class="edit">
    {{for.each($fields as $field)}}
    {{$require.basename = $field|uppercase.first.sentence:'.'}}
    {{require($prefix + $require.submodule + '/Section/Form/Component/Field/' + $require.basename + '.tpl')}}
    {{/for.each}}
</div>
