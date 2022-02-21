{{R3M}}
{{if(!is.empty($request.nodeList) && is.array($request.nodeList))}}
    {{for.each($request.nodeList as $nr => $node)}}
<div
    class="row align-items-start"
>
    <div class="col">
        <span class="title">Route path</span><br>
        <span class="title">Controller</span><br>
        <span class="title">Methods</span><br>
        {{for($i=0; $i < count($node.route.methods) - 1; $i++)}}
        <br>
        {{/for}}
    </div>
    <div class="col">
        <span class="content">{{$node.route.path}}</span><br>
        <span class="content">{{$node.route.controller}}</span><br>
        {{for.each($node.route.methods as $method)}}
        <span class="content">{{$method}}</span><br>
        {{/for.each}}
    </div>
</div>
    {{/for.each}}
{{/if}}
