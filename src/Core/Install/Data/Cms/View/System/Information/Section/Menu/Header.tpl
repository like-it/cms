{R3M}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link active system-information"
                data-url="{{server.url('core')}}System/Information/"
                data-frontend-url="{{route.get(route.prefix()+ '-system-information-body')}}"
                data-selected=".card-body-settings"
            >
                {{__('settings.section.email.header.settings')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link system-update"
                data-frontend-url="{{route.get(route.prefix()+ '-system-update-body')}}"
                data-selected=".card-body-add"
            >
                {{__('settings.section.email.header.add')}}
            </a>
        </li>
    </ul>
</div>