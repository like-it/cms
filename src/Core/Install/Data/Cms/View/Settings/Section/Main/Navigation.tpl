{R3M}
<section name="main-navigation" class="col-2">
    <div class="">
        <nav class="nav flex-column">
            <a
                    class="nav-link active"
                    data-url="{{server.url('core')}}Home/Body/"
                    data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="fas fa-home"></i> {{__('settings.link.import')}}
            </a>
            <a
                    class="nav-link"
                    data-url="{{server.url('core')}}Home/Body/"
                    data-frontend-url="{{route.get(route.prefix() + '-home-body')}}"
            >
                <i class="fas fa-home"></i> {{__('settings.link.export')}}
            </a>
            /*
            <a
                    class="nav-link" h
                    data-url="{{server.url('core')}}User/Profile/"
                    data-method="replace-with"
                    data-target="section[name='main-content']"
            >
                <i class="fas fa-user"></i> {{__('Home.link.profile')}}
            </a>
            <a
                    class="nav-link"
                    data-url="{{server.url('core')}}User/List/"
                    data-method="replace-with"
                    data-target="section[name='main-content']"
            >
                <i class="fas fa-users"></i> {{__('Home.link.users')}}
            </a>
            <a
                    class="nav-link"
                    data-url="{{server.url('core')}}System/Information/"
                    data-method="replace-with"
                    data-target="section[name='main-content']"
            >
                <i class="fas fa-cog"></i> {{__('Home.link.system')}}
            </a>
            <a class="nav-link" href="{{route.get(route.prefix() + '-user-logout')}}"><i class="fas fa-sign-out-alt"></i> Log out</a>
            */
        </nav>
    </div>
</section>