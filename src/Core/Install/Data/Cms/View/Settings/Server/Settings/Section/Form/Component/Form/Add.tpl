{{R3M}}
<div class="mb-3 section-form-component-field">
    {{for.each($fields as $field)}}
    {{$require.basename = $field|uppercase.first.sentence:'.'}}
    {{require($prefix + $require.submodule + '/Section/Form/Component/Field/' + $require.basename + '.tpl')}}
    {{/for.each}}
</div>
<div class="mb-3 section-form-component-button">
    {{require($prefix + $require.submodule + '/Section/Form/Component/Button/' + $require.action + '.tpl')}}
</div>