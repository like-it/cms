{{R3M}}
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.logs_and_errors_section.main.body.title')}}</h5>
    <table width="100%">
        <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Namespace</th>
            <th>Message</th>
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $nr => $node)}}
            <tr class="{{$node.type}}">
                <td class="date">
                    {{$node.date}}
                </td>
                <td class="type">
                    {{$node.type}}
                </td>
                <td class="namespace">
                    {{$node.namespace}}
                </td>
                <td class="message" title="{{$node.message}}">
                    {{$node.message|truncate:125}}
                </td>
            </tr>
        {{/for.each}}
        </tbody>
    </table>
</div>