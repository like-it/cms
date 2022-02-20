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
    {{$progress=75}}
    <div class="progress">
        <div
            class="progress-bar progress-bar-striped progress-bar-animated"
            role="progressbar"
            style="width: {{$progress}}%"
            aria-valuenow="{{$progress}}"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
    </div>
    <div class="progress">
        {{$progress=15}}
        <div
            class="progress-bar"
            role="progressbar"
            style="width: {{$progress}}%"
            aria-valuenow="{{$progress}}"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
        {{$progress=30}}
        <div
            class="progress-bar bg-success"
            role="progressbar"
            style="width: {{$progress}}%"
            aria-valuenow="{{$progress}}"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
        {{$progress=15}}
        <div
            class="progress-bar bg-info"
            role="progressbar"
            style="width: {{$progress}}%"
            aria-valuenow="{{$progress}}"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
    </div>
</div>