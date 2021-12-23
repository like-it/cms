{R3M}
<section name="main-navigation" class="col-12 col-md-2">
    <div class="">
        <nav class="nav flex-column">
            <a
                    class="nav-link active"
                    data-url="{{server.url('core')}}Home/Body/"
                    data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="{{__('home.icon.home.class')}}"></i> {{__('home.link.home')}}
            </a>
            <a
                    class="nav-link" h
                    data-url="{{server.url('core')}}User/Profile/"
                    data-method="replace-with"
                    data-target="section[name='main-content']"
            >
                <i class="{{__('home.icon.profile.class')}}"></i> {{__('home.link.profile')}}
            </a>
            <a
                    class="nav-link"
                    data-url="{{server.url('core')}}User/List/"
                    data-method="replace-with"
                    data-target="section[name='main-content']"
            >
                <i class="{{__('home.icon.users.class')}}"></i> {{__('home.link.users')}}
            </a>
            <a
                    class="nav-link"
                    data-url="{{server.url('core')}}System/Information/"
                    data-frontend-url="{{route.get(route.prefix() + '-system-information')}}"
            >
                <i class="{{__('home.icon.system.class')}}"></i> {{__('home.link.system')}}
            </a>
            <a
                    class="nav-link"
                    data-frontend-url="{{route.get(route.prefix() + '-user-logout')}}"
            >
                <i class="{{__('home.icon.logout.class')}}"></i> {{__('home.link.logout')}}
            </a>
        </nav>
    </div>
</section>