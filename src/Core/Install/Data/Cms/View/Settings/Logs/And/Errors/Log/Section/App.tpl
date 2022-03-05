{{R3M}}
{{dd($request()}}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.logs_and_errors_section.main.body.title')}}</h5>
    <table width="100%">
        <thead>
        <tr>
            <th>Status</th>
            <th>Ip address</th>
            <th>Method</th>
            <th>Path</th>
            <th>Date</th>
            <th>Size</th>
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $nr => $node)}}
            <tr>
                <td class="status">
                    {{if($node.status >= 200 && $node.status < 300)}}
                    <span class="green">
                        {{$node.status}}
                    </span>
                    {{else.if($node.status >= 400 && $node.status < 500)}}
                    <span class="red">
                        {{$node.status}}
                    </span>
                    {{else.if($node.status >= 500 && $node.status < 600)}}
                    <span class="purple">
                        {{$node.status}}
                    </span>
                    {{/if}}
                </td>
                <td>
                    {{$node.ipAddress}}
                </td>
                <td>
                    {{$node.method}}
                </td>
                <td title="{{$node.path}}">
                    {{$node.path|truncate:65}}
                </td>
                <td data-sort="{{$node.time}}">
                    {{$node.date}}
                </td>
                <td>
                    {{$node.size|file.size}}
                </td>
            </tr>
        {{/for}}
        </tbody>
    </table>
</div>