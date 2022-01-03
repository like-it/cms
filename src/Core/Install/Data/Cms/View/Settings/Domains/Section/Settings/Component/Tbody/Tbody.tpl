<tbody>
{{for.each($request.nodeList as $uuid => $node)}}
<tr
    data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
    data-frontend-url="{{route.get(route.prefix() + '-settings-email-edit-body')}}"
>
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Td/From.Name.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Td/From.Email.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Td/Host.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Td/Port.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Td/Options.tpl')}}
</tr>
{{/for.each}}
</tbody>