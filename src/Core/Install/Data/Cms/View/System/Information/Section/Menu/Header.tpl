{{R3M}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Information/Module/Menu.js')}}
{{/script}}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link active system-information"
                data-url="{{server.url('core')}}System/Information/"
                data-frontend-url="{{route.get(route.prefix()+ '-system-information-body')}}"
                data-selected=".card-body-settings"
            >
                {{__('system.information.section.menu.header.information')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link system-update"
                data-frontend-url="{{route.get(route.prefix()+ '-system-update-body')}}"
                data-selected=".card-body-add"
            >
                {{__('system.information.section.menu.header.update')}}
            </a>
        </li>
    </ul>
</div>