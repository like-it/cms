{{R3M}}
{{script('module')}}
{{require($prefix + 'Module/Menu.js')}}
{{/script}}
{{$lis = [
'Domain',
'Main',
'Settings'
]}}
<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        {{for.each($lis as $li)}}
        {{require($controller.dir.component + $require.module + '/Menu/Li/'+ $li + '.tpl')}}
        {{/for.each}}
    </ul>
</div>