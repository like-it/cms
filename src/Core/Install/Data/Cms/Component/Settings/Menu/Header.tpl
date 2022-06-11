{{R3M}}
/*
{{script('module')}}
{{require($prefix + 'Module/Menu.js')}}
{{/script}}
*/
{{$li = [
'Domain',
'Main',
'Settings'
]}}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        {{for.each($li as $item)}}
        {{require($controller.dir.component + $require.module + '/Menu/Li/'+ $item + '.tpl')}}
        {{/for.each}}
    </ul>
</div>