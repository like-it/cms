{{R3M}}
{{$components = [
'actions',
'icon',
'name',
'url',
'options'
]}}
{{$options = [
'edit',
'view',
'rename',
'delete'
]}}
{{$actions = [
'copy',
'move',
'delete'
]}}
{{$limits = [
'10',
'25',
'50',
'100',
'250',
'500',
'1000'
]}}
{{$filters = [
'dir',
'file',
'tpl',
'js',
'json',
'css',
'all'
]}}
{{$addons = [
'dir',
'file',
'symlink',
'upload'
]}}
<div class="card-body h-100 card-body-{{$command}}">
    <table class="table table-hover">
        <thead>
        <tr>
            {{for.each($components as $component)}}
            <th scope="col" class="th-{{$component}}">{{__(
                'component' +
                '.' +
                $__.module +
                '.' +
                'settings' +
                '.' +
                'body' +
                '.' +
                'thead' +
                '.' +
                $component
            )}}
            </th>
            {{/for.each}}
        </tr>
        </thead>
        <tbody>
        {{$nr = 0 }}
        {{$count = 0}}
        {{if(!is.empty($request.nodeList))}}
            {{for.each($request.nodeList as $node_nr => $node)}}
            {{$count++}}
            {{/for.each}}
            {{for.each($request.nodeList as $node_nr => $node)}}
                {{if($node.type === 'Dir')}}
                    <tr>
                {{else}}
                    <tr
                        data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.raw.encode}}/{{$node.domain}}"
                        data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-template-body')}}"
                    >
                {{/if}}
                {{for.each($components as $component)}}
                    {{$require.basename = $component|uppercase.first.sentence:'.'}}
                    {{require($controller.dir.component + $require.module + '/' + $require.submodule + '/Td/' + $require.basename + '.tpl')}}
                {{/for.each}}
                </tr>
                {{$nr++}}
            {{/for.each}}
        {{else}}
            <tr>
                <td colspan="{{array.count($components)}}">
                    {{__(
                    'component' +
                    '.' +
                    $__.module +
                    '.' +
                    'settings' +
                    '.' +
                    'body' +
                    '.' +
                    'tbody' +
                    '.' +
                    'no' +
                    '.' +
                    'records'
                    )}}
                </td>
            </tr>
        {{/if}}
        </tbody>
        {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Footer.tpl')}}
    </table>
</div>