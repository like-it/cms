{R3M}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a
                class="nav-link active settings-email-main"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-main-body')}}"
            >
                {{__('settings.section.email.header.main')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link settings-email-settings"
                data-url="{{server.url('core')}}Settings/Email/Settings/"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-settings-body')}}"
            >
                {{__('settings.section.email.header.settings')}}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link settings-email-add"
                data-frontend-url="{{route.get(route.prefix()+ '-settings-email-add-body')}}"
            >
                {{__('settings.section.email.header.add')}}
            </a>
        </li>
        /*
        {{if(!is.empty($request.node.uuid))}}
        <li class="nav-item">
            <a
                    class="nav-link settings-email-edit-{{$request.node.uuid}}"
                    data-url="{{server.url('core')}}Settings/Email/{{$request.node.uuid}}"
                    data-frontend-url="{{route.get(route.prefix()+ '-settings-email-edit')}}"
            >
                {{$request.node.from.name}}
            </a>
        </li>
        {{/if}}
        */
    </ul>
</div>