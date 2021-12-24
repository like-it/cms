{R3M}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link active"
                aria-current="true"
                data-frontend-url="{{route.get(route.prefix() + '-settings-logs-and-errors-body')}}">
                {{__('settings.logs_and_errors.section.header.main')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Log/Access"
                data-frontend-url=""
            >
                {{__('settings.logs_and_errors.section.header.access_log')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Log/Error"
                data-frontend-url=""
            >
                {{__('settings.logs_and_errors.section.header.error_log')}}
            </a>
        </li>
    </ul>
</div>