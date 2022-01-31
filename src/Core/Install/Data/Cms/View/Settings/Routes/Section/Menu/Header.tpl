{{R3M}}
{{script('module')}}
{{require($prefix + 'Module/Menu.js')}}
{{/script}}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        {{require($prefix + $require.submodule + '/Section/Menu/Component/Li/Domain.tpl')}}
        {{require($prefix + $require.submodule + '/Section/Menu/Component/Li/Main.tpl')}}
        {{require($prefix + $require.submodule + '/Section/Menu/Component/Li/Settings.tpl')}}
        {{require($prefix + $require.submodule + '/Section/Menu/Component/Li/Add.Route.tpl')}}
        {{require($prefix + $require.submodule + '/Section/Menu/Component/Li/Add.Redirect.tpl')}}
    </ul>
</div>