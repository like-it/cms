{{R3M}}
<div class="section-form-component-menu">
    {{require($prefix + $require.submodule + '/Section/Form/Component/Menu/' + $require.action + '.tpl')}}
</div>
<div class="section-form-component-field">
    {{for.each($fields as $field)}}
    {{$require.basename = $field|uppercase.first.sentence:'.'}}
    {{require($prefix + $require.submodule + '/Section/Form/Component/Field/' + $require.basename + '.tpl')}}
    {{/for.each}}
</div>
