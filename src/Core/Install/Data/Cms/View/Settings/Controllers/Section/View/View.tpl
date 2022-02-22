{{R3M}}
<div class="progress" style="height: 1px">
    {{$progress=10}}
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
        class="progress-bar"
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
            <h5>Internal name</h5>
        </div>
        <div class="col">
            <h5>{{$request.node.name}}</h5>
        </div>
    </div>
    {{/if}}
    <div
        class="row align-items-start settings-routes-settings"
        data-url="{{server.url('core')}}Settings/Routes/Settings/{{$request.node.domain.uuid}}?pagination=false"
        data-frontend-url="{{route.get(route.prefix() + '-settings-controllers-view-routes-body')}}"
        data-controller-name="{{$request.node.name}}"
    >
        <div class="col">
            <span class="title">Loading routes...</span><br>
        </div>
    </div>
</div>