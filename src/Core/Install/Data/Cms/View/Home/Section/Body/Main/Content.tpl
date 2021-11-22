{{$section.name = 'main-content'}}
{{$section.title = 'Main-content'}}
{{$request.method = 'replace-with-or-append-to'}}
{{$request.target = 'section[name="' + $section.name + '"]'}}
{{$request.append.to = 'body'}}
<section name="main-content" class="col-10">
    <div class="h-100">
        <div class="card h-100 overflow-auto">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="true" href="#">Main</a>
                    </li>
                </ul>
            </div>
            <div class="card-body h-100">
                <h5 class="card-title">Settings</h5>
                <ul>
                    <li>Account settings</li>
                    <li>Basic site settings</li>
                    <li>Editor settings</li>
                    <li>Export</li>
                    <li>File System</li>
                    <li>Import</li>
                    <li>Loggers</li>
                    <li>Mode</li>
                    <li>Nodes</li>
                    <li>Style sheets & elements</li>
                    <li>Token settings</li>
                </ul>
            </div>
        </div>
    </div>
</section>