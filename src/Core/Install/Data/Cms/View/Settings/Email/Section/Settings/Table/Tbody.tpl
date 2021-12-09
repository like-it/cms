<tbody>
{{for.each($request.nodeList as $uuid => $node)}}
<tr
    data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
    data-frontend-url="{{route.get(route.prefix() + '-settings-email-edit-body')}}"
>
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Td/Node/From.Name.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Td/Node/From.Email.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Td/Node/Host.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Td/Node/Port.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Td/Options/Options.tpl')}}
</tr>
{{/for.each}}
</tbody>