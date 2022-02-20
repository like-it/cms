{{R3M}}
<div class="container">
    {{if(!is.empty($request.node.key))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Key</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.key}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.node.name))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Internal name</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.name}}</span><br>
        </div>
    </div>
    {{/if}}
    //load routes
</div>