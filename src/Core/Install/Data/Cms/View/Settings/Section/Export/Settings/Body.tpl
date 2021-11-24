{R3M}
{{$version = config('version')}}
{{if(is.empty($version))}}
    {{$version = '0.0.1'}}
{{/if}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Module/Export.Settings.js')}}
{{/script}}
<form name="config-version" data-url="{{server.url('core')}}Config/Version/" method="post">
<div class="card-body h-100">
    <h5 class="card-title">Settings</h5>
    <p class="card-text">The exported zip will have this version number.</p>
    <label for="version">Version:</label>
    <input id="version" name="version" value="{{$version}}"/>
    <input type="submit" name="save" value="Save"/>
</div>
</form>