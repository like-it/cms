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
        <h5>Routes</h5>
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
        <span class="title">Key</span><br>
        <span class="title">Get</span><br>
        <span class="title">Url</span><br>
        <span class="title">Controller</span><br>
        <span class="title">Function (Action)</span><br>
        <span class="title">Request methods</span><br>
        {{$count = array.count($node.route.method)}}
        {{for($i=1; $i < $count ; $i++)}}
        <br>
        {{/for}}
    </div>
    <div class="col">
        <span class="content">{{$node.route.key}}</span><br>
        <span class="content"><code>{{literal}}{{route.get(route.prefix() + '-{{/literal}}{{$node.name}}{{literal}}')}}{{/literal}}</code></span><br>
        <span class="content">{{array.reset('$node.route.host')}}{{$node.route.path}}</span><br>
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
