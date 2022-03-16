{{R3M}}
<ul class="settings-controllers-menu">
    <li
        data-class="panel-file"
    >
        <a
            class="menu-file"
        >
            {{__('settings.controllers.section.form.component.menu.file')}}
        </a>
    </li>
    <li
        data-class="panel-edit"
    >
        <a
            class="menu-edit"
        >
            {{__('settings.controllers.section.form.component.menu.edit')}}
        </a>
    </li>
</ul>
{{require($prefix + $require.submodule + '/Section/Form/Component/Menu/Panel/File.tpl')}}
{{require($prefix + $require.submodule + '/Section/Form/Component/Menu/Panel/Edit.tpl')}}
