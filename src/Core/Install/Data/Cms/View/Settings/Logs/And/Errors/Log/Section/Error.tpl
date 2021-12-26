{R3M}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.logs_and_errors_section.main.body.title')}}</h5>
    <table width="100%">
        <thead>
        <tr>
            <th>Client</th>
            <th>Pid</th>
            <th>Date</th>
            <th>Level</th>
            <th>Referer</th>
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $nr => $node)}}
            <tr>
                <td class="client">
                    {{$node.client}}
                </td>
                <td>
                    {{$node.pid}}
                </td>
                <td>
                    {{$node.date}}
                </td>
                <td>
                    {{$node.level}}
                </td>
                <td>
                    {{$node.referer|default:''}}
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    {{$node.message}}
                </td>
            </tr>
        {{/for}}
        </tbody>
    </table>
</div>