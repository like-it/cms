{R3M}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $controller.name + '"]'}}
{{$request.append.to = 'body'}}
<section name="{{$controller.name}}">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{__('navbar.brand')}}</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="{{__('navbar.label')}}"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            aria-current="page"
                            data-url="{{route.get(route.prefix() + '-home-main')}}"
                        >{{__('navbar.home')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{__('navbar.content')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{__('navbar.media')}}</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-url="{{route.get(route.prefix() + '-settings-main')}}"
                        >{{__('navbar.settings')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{__('navbar.translations')}}</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input
                        class="form-control me-2"
                        type="{{__('navbar.search.type')}}"
                        placeholder="{{__('navbar.search.placeholder')}}"
                        aria-label="{{__('navbar.search.label')}}"
                        name="q"
                    >
                    <button
                        class="btn btn-outline-success"
                        type="submit"
                    >{{__('navbar.search')}}</button>
                </form>
            </div>
        </div>
    </nav>
</section>