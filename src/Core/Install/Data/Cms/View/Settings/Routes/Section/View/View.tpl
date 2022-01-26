{{R3M}}

<div class="container">
    {{if(!is.empty($request.node.module))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Module</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.module}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.node.submodule))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Submodule</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.submodule}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.node.command))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Command</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.command}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.node.subcommand))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Subcommand</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.subcommand}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.node.redirect))}}
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
    {{if(!is.empty($request.node.sort))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Internal sort</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.sort}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.route.host))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Route host</span><br>
        </div>
        <div class="col">
        {{for.each($request.route.host as $host)}}
            <span class="content">{{$host}}</span><br>
        {{/for.each}}
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.route.method))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Route method</span><br>
        </div>
        <div class="col">
            {{for.each($request.route.method as $method)}}
            <span class="content">{{$method}}</span><br>
            {{/for.each}}
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.route.path))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Route path</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.route.path}}</span><br>
        </div>
    </div>
    {{/if}}


    <div class="row align-items-start">
        <div class="col">
            <span class="title">Route Redirect</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.route.redirect}}</span><br>
        </div>
    </div>
    {{/if}}
</div>