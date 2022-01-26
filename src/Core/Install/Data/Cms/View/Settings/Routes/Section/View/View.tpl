{{R3M}}

<div class="container">
    <div class="row align-items-start">
        <div class="col">
        {{if(!is.empty($request.node.module))}}
            <span class="title">Module</span>
        {{/if}}
        {{if(!is.empty($request.node.submodule))}}
            <span class="title">Submodule</span>
        {{/if}}
        {{if(!is.empty($request.node.command))}}
            <span class="title">Command</span>
        {{/if}}
        {{if(!is.empty($request.node.subcommand))}}
            <span class="title">Subcommand</span>
        {{/if}}
        {{if(!is.empty($request.node.redirect))}}
            <span class="title">Redirect</span>
        {{/if}}
        </div>
        <div class="col">
        {{if(!is.empty($request.node.module))}}
            <span class="content">{{$request.node.module}}</span>
        {{/if}}
        {{if(!is.empty($request.node.submodule))}}
            <span class="content">{{$request.node.submodule}}</span>
        {{/if}}
        {{if(!is.empty($request.node.command))}}
            <span class="content">{{$request.node.command}}</span>
        {{/if}}
        {{if(!is.empty($request.node.subcommand))}}
            <span class="content">{{$request.node.subcommand}}</span>
        {{/if}}
        {{if(!is.empty($request.node.redirect))}}
            <span class="content">{{$request.node.redirect}}</span>
        {{/if}}
        </div>
    </div>
</div>