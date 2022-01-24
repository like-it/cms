{{R3M}}
<td scope="row" class="actions">
    {{if($nr > 0 || $request.page > 1)}}
        {{$action = '1-up'}}
        {{$__.action = $action|lowercase|replace:'-':'.'}}
        {{$require.action = $action|uppercase.first.sentence:'-'|replace:'-':'/'}}
        <i
            class="fas fa-chevron-up"
            data-request-method="POST"
            data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$node.uuid}}/{node.domain}"
        >
        </i>
        <br>
    {{/if}}
    {{if($nr < $count - 1 || $request.max > $request.page)}}
        {{$action = '1-down'}}
        {{$__.action = $action|lowercase|replace:'-':'.'}}
        {{$require.action = $action|uppercase.first.sentence:'-'|replace:'-':'/'}}
        {{if($request.max > $request.max && $nr == ($count - 1)}}
            <i
                class="fas fa-chevron-down"
                data-request-method="POST"
                data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$node.uuid}}/{node.domain}"
                data-move-to-next-page="true"
            >
            </i>
        {{else}}
            <i
                class="fas fa-chevron-down"
                data-request-method="POST"
                data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$node.uuid}}/{node.domain}"
            >
            </i>
        {{/if}}
        <br>
    {{/if}}
</td>