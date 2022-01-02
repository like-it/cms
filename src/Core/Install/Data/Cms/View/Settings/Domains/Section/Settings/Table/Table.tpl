{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{if(!is.empty($request.nodeList))}}
<table class="table">
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Thead.tpl')}}
    {{require($controller.dir.view + $controller.title + '/Email/Section/Settings/Table/Tbody.tpl')}}
</table>
{{/if}}