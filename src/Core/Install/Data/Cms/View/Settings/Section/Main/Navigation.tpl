{R3M}
<section name="main-navigation" class="col-12 col-md-4">
    <div class="">
        <nav class="nav flex-column">
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-settings-body')}}"
            >
                <i class="{{__('settings.icon.account_settings.class')}}"></i> {{__('settings.link.account_settings')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-settings-body')}}"
            >
                <i class="{{__('settings.icon.basic_site_settings.class')}}"></i> {{__('settings.link.basic_site_settings')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-settings-body')}}"
            >
                <i class="{{__('settings.icon.editor_settings.class')}}"></i> {{__('settings.link.editor_settings')}}
            </a>
            <a
                    class="nav-link"
                    data-frontend-url="{{route.get(route.prefix() + '-settings-email-main')}}"
            >
                <i class="{{__('settings.icon.email.class')}}"></i> {{__('settings.link.email')}}
            </a>
            <a
                class="nav-link"
                data-frontend-url="{{route.get(route.prefix() + '-settings-export')}}"
            >
                <i class="{{__('settings.icon.export.class')}}"></i> {{__('settings.link.export')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-settings-body')}}"
            >
                <i class="{{__('settings.icon.file_system.class')}}"></i> {{__('settings.link.file_system')}}
            </a>
            <a
                class="nav-link"
                data-frontend-url="{{route.get(route.prefix() + '-settings-import')}}"
            >
                <i class="{{__('settings.icon.import.class')}}"></i> {{__('settings.link.import')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Settings/Export/"
                data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('settings.icon.logs_and_errors.class')}}"></i> {{__('settings.link.logs_and_errors')}}
            </a>
            <a
                class="nav-link active"
                data-url="{{server.url('core')}}Settings/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-settings-body')}}"
            >
                <i class="{{__('settings.icon.main.class')}}"></i> {{__('settings.link.main')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Home/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('settings.icon.mode.class')}}"></i> {{__('settings.link.mode')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Home/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('settings.icon.nodes.class')}}"></i> {{__('settings.link.nodes')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Home/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('settings.icon.style_sheets_and_elements.class')}}"></i> {{__('settings.link.style_sheets_and_elements')}}
            </a>
            <a
                    class="nav-link"
                    data-url="{{server.url('core')}}Home/Body/"
                    data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('settings.icon.templates.class')}}"></i> {{__('settings.link.templates')}}
            </a>
            <a
                class="nav-link"
                data-url="{{server.url('core')}}Home/Body/"
                data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('settings.icon.token_settings.class')}}"></i> {{__('settings.link.token_settings')}}
            </a>
        </nav>
    </div>
</section>