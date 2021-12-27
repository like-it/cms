{R3M}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Email/Module/Menu.js')}}
{{/script}}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link active settings-email-main"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-main-body')}}"
                data-selected=".card-body-main"
            >
                {{__('settings.section.email.header.main')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link settings-email-settings"
                data-url="{{server.url('core')}}Settings/Email/Settings/"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-settings-body')}}"
                data-selected=".card-body-settings"
            >
                {{__('settings.section.email.header.settings')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link settings-email-add"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-add-body')}}"
                data-selected=".card-body-add"
            >
                {{__('settings.section.email.header.add')}}
            </a>
        </li>
    </ul>
</div>