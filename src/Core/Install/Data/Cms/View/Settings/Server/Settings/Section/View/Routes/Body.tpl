{{R3M}}
{{if(
    !is.empty($request.nodeList) &&
    (
    is.array($request.nodeList) ||
    is.object($request.nodeList)
    )
)}}
<div
    class="row align-items-start"
>
    <div class="col">
        <h5>{{__('settings.controllers.section.view.routes.body.title')}}</h5>
    </div>
</div>
    {{for.each($request.nodeList as $nr => $node)}}
<div
    class="row align-items-start"
>
    <div class="col">
        <hr>
    </div>
</div>
<div
    class="row align-items-start"
>
    <div class="col">
        <span class="title">{{__('settings.controllers.section.view.routes.body.node.url')}}</span><br>
        <span class="title">{{__('settings.controllers.section.view.routes.body.node.key')}}</span><br>
        <span class="title">{{__('settings.controllers.section.view.routes.body.node.get')}}</span><br>
        <span class="title">{{__('settings.controllers.section.view.routes.body.node.controller')}}</span><br>
        <span class="title">{{__('settings.controllers.section.view.routes.body.node.function')}}</span><br>
        <span class="title">{{__('settings.controllers.section.view.routes.body.node.request.methods')}}</span><br>
        {{$count = array.count($node.route.method)}}
        {{for($i=1; $i < $count ; $i++)}}
        <br>
        {{/for}}
    </div>
    <div class="col">
        <span class="content">{{array.reset('$node.route.host')}}{{$node.route.path}}</span><br>
        <span class="content">{{$node.route.key}}</span><br>
        <span class="content"><code>{{literal}}{{route.get(route.prefix() + '-{{/literal}}{{$node.name}}{{literal}}')}}{{/literal}}</code></span><br>
        {{$explode = explode('.', $node.route.controller)}}
        {{$function = array.pop('$explode')}}
        {{$_controller = implode('.', $explode)}}
        <span class="content">{{$_controller}}</span><br>
        <span class="content">{{$function}}</span><br>
        {{for.each($node.route.method as $route_method)}}
        <span class="content">{{$route_method}}</span><br>
        {{/for.each}}
    </div>
</div>
    {{/for.each}}
{{/if}}
