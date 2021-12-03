{R3M}
<div class="card-body h-100">

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
                        ></i>
                        {{/if}}
                        <i class="far fa-edit settings-email-settings-edit"></i>
                        <i class="far fa-trash-alt settings-email-settings-delete"></i>
                    </td>
                </tr>
            {{/for.each}}
            </tbody>
        </table>
    {{/if}}
</div>