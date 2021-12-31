{R3M}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-export')}}"
            >
                {{__('settings.section.export.header.export')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link active"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-export-settings')}}"
            >
                {{__('settings.section.export.header.settings')}}
            </a>
        </li>
    </ul>
</div>