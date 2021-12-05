{R3M}
{{if($is.settings.body)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-settings'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Email/Module/Settings.js')}}
{{/script}}
<div class="card-body h-100 card-body-settings">

    {{if(!is.empty($request.email))}}
        <table class="table">
            <thead>
            <tr>
                <th scope="col">host</th>
                <th scope="col">Port</th>
                <th scope="col">From e-mail</th>
                <th scope="col">From name</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            {{for.each($request.email as $uuid => $account)}}
                <tr>
                    <td scope="row">{{$account.host}}</td>
                    <td>{{$account.port}}</td>
                    <td>
                        {{$account.from.email}}
                    </td>
                    <td>{{$account.from.name}}</td>
                    <td>
                        {{if(!is.empty($account.isDefault))}}
                        <i class="fas fa-award settings-email-settings-is-default" title="Default account"></i>
                        {{else}}
                        <i
                            class="fas fa-sign-out-alt settings-email-account-default"
                            title="Make default account"
                            data-url="{{server.url('core')}}Settings/Email/Account/Default/{{$uuid}}"
                        >
                        </i>
                        {{/if}}
                        <i
                            class="far fa-edit settings-email-settings-edit"
                            data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
                            data-frontend-url="{{route.get(route.prefix() + '-settings-email-edit-body')}}"
                        >
                        </i>
                        <i
                            class="far fa-trash-alt settings-email-settings-delete"
                            data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
                            data-request-method="DELETE"
                        >
                        </i>
                    </td>
                </tr>
            {{/for.each}}
            </tbody>
        </table>
    {{/if}}
</div>