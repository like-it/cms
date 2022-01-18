{{R3M}}
<td scope="row" class="actions">
    {{if($nr > 0)}}
        {{$action = '1-up'}}
        {{$__.action = $action|lowercase|replace:'-':'.'}}
        {{$require.action = $action|uppercase.first.sentence:'-'|replace:'-':'/'}}
        <i
            class="fas fa-chevron-up"
            data-request-method="POST"
            data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$uuid}}"
        >
        </i>
        <br>
    {{/if}}
    {{if($nr < $count - 1)}}
        {{$action = '1-down'}}
        {{$__.action = $action|lowercase|replace:'-':'.'}}
        {{$require.action = $action|uppercase.first.sentence:'-'|replace:'-':'/'}}
        <i
            class="fas fa-chevron-down"
            data-request-method="POST"
            data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$uuid}}"
        >
        </i>
        <br>
    {{/if}}
</td>