{{R3M}}
{{$version = config('version')}}
{{if(is.empty($version))}}
    {{$version = '0.0.1'}}
{{/if}}
/*
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Export/Module/Settings.js')}}
{{/script}}
*/
<form name="config-version" data-url="{{server.url('core')}}Config/Version/" method="post">
<div class="card-body h-100">
    <h5 class="card-title">{{__('settings.section.export.settings.body.title')}}</h5>
    <p class="card-text">{{__('settings.section.export.settings.body.text')}}</p>
    <label for="version">{{__('settings.section.export.settings.body.label')}}</label>
    <input id="version" name="version" value="{{$version}}"/>
    <input type="submit" name="save" value="{{__('settings.section.export.settings.body.save')}}"/>
</div>
</form>