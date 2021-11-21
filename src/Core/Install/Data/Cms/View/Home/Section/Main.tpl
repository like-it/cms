{R3M}
{{$section.name = 'main'}}
{{$section.title = 'Main'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
{{import($section.title +'.css')}}
<section name="{{$section.name}}">
    <div class="container mw-100 h-100">
        <div class="row h-100">
            <section name="main-navigation" class="col-2">
                <div class="">
                    <nav class="nav flex-column">
                        <a
                            class="nav-link active"
                            data-url="{{server.url('core')}}Home/Body/"
                            data-method="replace-with"
                            data-target="section[name='main-content']"
                        >
                            <i class="fas fa-home"></i> Home
                        </a>
                        <a
                            class="nav-link" h
                            data-url="{{server.url('core')}}User/Profile/"
                            data-method="replace-with"
                            data-target="section[name='main-content']"
                        >
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a
                            class="nav-link"
                            data-url="{{server.url('core')}}User/List/"
                            data-method="replace-with"
                            data-target="section[name='main-content']"
                        >
                            <i class="fas fa-users"></i> Users
                        </a>
                        <a
                            class="nav-link"
                            data-url="{{server.url('core')}}System/Information/"
                            data-method="replace-with"
                            data-target="section[name='main-content']"
                        >
                            <i class="fas fa-cog"></i> System
                        </a>
                        <a class="nav-link" href="{{route.get(route.prefix() + '-user-logout')}}"><i class="fas fa-sign-out-alt"></i> Log out</a>
                    </nav>
                </div>
            </section>
        </div>
    </div>
</section>
