{R3M}
{{if($request.error)}}
{{/if}}
{{if($is.update.body)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-update'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Update/Module/Update.js')}}
{{/script}}
<div class="card-body h-100 card-body-update" data-menu=".system-update">
    <p class="text-start">
        {{implode('<br>', __('system.update.section.main.body.text'))}}
    </p>
    <a
        class="btn btn-primary"
        data-url="{{server.url('core')}}System/Update/Cms/"
        data-method="replace"
        data-target=".system-console"
    >
        {{__('system.update.section.main.body.button.update.cms')}}
    </a>
    <br>
    <a
        class="btn btn-primary"
        data-url="{{server.url('core')}}Admin/Taskrunner/Restart/"
        data-method="replace"
        data-target=".system-console"
    >
        {{__('system.update.section.main.body.button.admin.taskrunner.restart')}}
    </a>
    <br><br>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            aria-current="true"
                        >
                            Console
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body system-console h-100 text-start">
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</div>