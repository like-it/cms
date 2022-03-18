{{R3M}}
<div class="container">
    {{if(!is.empty($request.node.key))}}
    <div class="row align-items-start">
        <div class="col">
            <span class="title">{{__('settings.controllers.section.view.view.node.key')}}</span><br>
        </div>
        <div class="col">
            <span class="content">{{$request.node.key}}</span><br>
        </div>
    </div>
    {{/if}}
    {{if(!is.empty($request.node.url))}}
    <div class="row align-items-start">
        <div class="col">
            <h5>{{__('settings.controllers.section.view.view.node.url')}}</h5>
        </div>
        <div class="col">
            <h5>{{$request.node.url}}</h5>
        </div>
    </div>
    {{/if}}
    {{if(in.array(
    $request.node.extension,
    image.extensions()
    ))}}
    <div class="row align-items-start">
        <img src="data:{{image.content.type($request.node.extension)}};base64,{{$request.node.content}}" alt="{{$request.node.name}}">
    </div>
    {{/if}}
</div>