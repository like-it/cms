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
    <div class="row align-items-start">
        <div class="col">
            <span class="title">Redirect</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.redirect}}</span><br>
        </div>
    </div>
    {{/if}}
</div>