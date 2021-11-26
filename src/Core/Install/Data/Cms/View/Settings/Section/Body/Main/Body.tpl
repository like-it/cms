{R3M}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.section.body.body.title')}}</h5>
    <ul>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Account_settings.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Basic_site_settings.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Editor_settings.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Export.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/File_system.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Import.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Loggers.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Mode.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Nodes.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Style_sheets_and_elements.tpl')}}
        </li>
        <li>
            {{require($controller.dir.view + $controller.title + '/Section/Body/Main/Li/Token_settings.tpl')}}
        </li>
    </ul>
</div>