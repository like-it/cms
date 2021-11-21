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
                            data-target="section[name='main']"
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
            <section name="main-content" class="col-10">
                <div class="h-100">
                    <div class="card h-100 overflow-auto">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="true" href="#">Active</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Link</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled">Disabled</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body h-100">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Accordion Item #3
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
</section>
