{{R3M}}
<div class="progress" style="height: 1px">
    {{$progress=0}}
    <div
        class="progress-bar bg-progress-bar"
        role="progressbar"
        style="width: {{$progress}}%"
        aria-valuenow="{{$progress}}"
        aria-valuemin="0"
        aria-valuemax="100"
    ></div>
    {{$progress=10}}
    <div
        class="progress-bar progress-bar-striped progress-bar-animated"
        role="progressbar"
        style="width: {{$progress}}%"
        aria-valuenow="{{$progress}}"
        aria-valuemin="0"
        aria-valuemax="100"
    ></div>
</div>
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
</div>