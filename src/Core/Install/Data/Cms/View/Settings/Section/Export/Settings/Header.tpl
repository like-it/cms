{R3M}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-export')}}"
            >
                Export
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link active"
                data-url="{{server.url('core')}}Settings/Export/Settings/"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-export-settings')}}"
            >
                Settings
            </a>
        </li>
    </ul>
</div>