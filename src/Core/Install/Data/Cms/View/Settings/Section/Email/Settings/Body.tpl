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
                <th scope="col">Default</th>
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
                        <i class="fas fa-award" title="Default account"></i>
                        {{else}}
                        <i class="fas fa-sign-out-alt" title="Make default account"></i>
                        {{/if}}
                    </td>
                    <td>
                        <i class="far fa-edit"></i>
                        <i class="far fa-trash-alt"></i>
                        <i class="far fa-envelope"></i>
                    </td>
                </tr>
            {{/for.each}}
            </tbody>
        </table>
    {{/if}}
</div>