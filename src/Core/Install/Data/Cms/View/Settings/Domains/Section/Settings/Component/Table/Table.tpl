{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{if(!is.empty($request.nodeList))}}
<table class="table">
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Thead/Thead.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Body/Component/Tbody/Tbody.tpl')}}
</table>
{{/if}}