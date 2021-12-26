{R3M}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.logs_and_errors_section.main.body.title')}}</h5>
    <table width="100%">
        <thead>
        <tr>
            <th>Status</th>
            <th>Ip address</th>
            <th>Method</th>
            <th>Path</th>
            <th>Size</th>
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $nr => $node)}}
            <tr>
                <td>
                    {{$node.status}}
                </td>
                <td>
                    {{$node.ipAddress}}
                </td>
                <td>
                    {{$node.method}}
                </td>
                <td>
                    {{$node.path}}
                </td>
                <td>
                    {{$node.size|file.size}}
                </td>
            </tr>
        {{/for}}
        </tbody>
    </table>
</div>