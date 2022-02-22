{{R3M}}
{{if(
    !is.empty($request.nodeList) &&
    (
    is.array($request.nodeList) ||
    is.object($request.nodeList)
    )
)}}
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
        <span class="title">Module</span><br>
        {{if(!is.empty($node.submodule))}}
        <span class="title">Submodule</span><br>
        {{/if}}
        {{if(!is.empty($node.command))}}
        <span class="title">Command</span><br>
        {{/if}}
        {{if(!is.empty($node.subcommand))}}
        <span class="title">Subcommand</span><br>
        {{/if}}
        <span class="title">Url</span><br>
        <span class="title">Controller</span><br>
        <span class="title">Function (Action)</span><br>
        <span class="title">Methods</span><br>
        {{$count = array.count($node.route.method)}}
        {{for($i=1; $i < $count ; $i++)}}
        <br>
        {{/for}}
    </div>
    <div class="col">
        <span class="content">{{$node.module}}</span><br>
        {{if(!is.empty($node.submodule))}}
            <span class="content">{{$node.submodule}}</span><br>
        {{/if}}
        {{if(!is.empty($node.command))}}
            <span class="content">{{$node.command}}</span><br>
        {{/if}}
        {{if(!is.empty($node.subcommand))}}
            <span class="content">{{$node.subcommand}}</span><br>
        {{/if}}
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
