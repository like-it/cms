{R3M}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Email/Module/Menu.js')}}
{{/script}}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        {{require($controller.dir.view + $controller.title + '/Email/Section/Menu/Component/Li/Main.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Menu/Component/Li/Settings.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Menu/Component/Li/Add.tpl')}}
    </ul>
</div>