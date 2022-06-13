{{R3M}}
<td class="actions">
    {{if(is.empty($node.protected))}}
        <input id="checkbox-{{$node.uuid}}" type="checkbox" name="node.nodeList[]" value="{{$node.url}}" />
    {{/if}}
    {{if(!is.empty($node.sort))}}
        {{if($nr > 0 || $request.page > 1)}}
            {{$action = '1-up'}}
            {{$__.action = $action|lowercase|replace:'-':'.'}}
            {{$require.action = $action|uppercase.first.sentence:'-'|replace:'-':'/'}}
            {{if($nr === 0 && $request.page > 1)}}
                <i
                    class="fas fa-chevron-up"
                    data-request-method="POST"
                    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$node.uuid}}/{node.domain}"
                    data-move-to-previous-page="true"
                >
                </i>
            {{else}}
                <i
                    class="fas fa-chevron-up"
                    data-request-method="POST"
                    data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.action}}/{{$node.uuid}}/{node.domain}"
                >
                </i>
            {{/if}}

            <br>
        {{/if}}
        {{if($nr < $count - 1 || $request.max > $request.page)}}
            {{$action = '1-down'}}
            {{$__.action = $action|lowercase|replace:'-':'.'}}
            {{$require.action = $action|uppercase.first.sentence:'-'|replace:'-':'/'}}
            {{if($request.max > $request.page && $nr == $count - 1)}}
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
    {{/if}}
</td>