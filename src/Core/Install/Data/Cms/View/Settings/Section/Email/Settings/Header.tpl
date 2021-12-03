{R3M}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link settings-email-main"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-main')}}"
            >
                {{__('settings.section.email.header.main')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link active settings-email-settings"
                data-url="{{server.url('core')}}Settings/Email/Settings/"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-settings')}}"
            >
                {{__('settings.section.email.header.settings')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                    class="nav-link settings-email-add"
                    data-url="{{server.url('core')}}Settings/Email/Add/"
                    data-frontend-url="{{route.get(route.prefix()+ '-settings-email-add')}}"
            >
                {{__('settings.section.email.header.add')}}
            </a>
        </li>
    </ul>
</div>