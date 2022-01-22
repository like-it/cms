{{R3M}}
{{$components = [
'actions',
'module',
'submodule',
'command',
'subcommand',
'path',
'method',
'options'
]}}
{{$options = [
'edit',
'view',
'controller',
'delete'
]}}
<div class="card-body h-100 card-body-{{$command}}">
    {{if(!is.empty($request.nodeList))}}
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            {{for.each($components as $component)}}
            <th scope="col">{{__(
                $__.module +
                '.' +
                $__.submodule +
                '.section.' +
                $__.command +
                '.component.thead.' +
                $component
            )}}
            </th>
            {{/for.each}}
        </tr>
        </thead>
        <tbody>
        {{$nr = 0 }}
        {{$count = 0}}
        {{for.each($request.nodeList as $uuid => $node)}}
            {{$count++}}
        {{/for.each}}
        {{for.each($request.nodeList as $uuid => $node)}}
        {{if(!is.empty($node.redirect))}}
        <tr
            data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$uuid}}/{{$node.domain}}"
            data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-redirect-body')}}"
        >
        {{else}}
        <tr
            data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$uuid}}/{{$node.domain}}"
            data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-route-body')}}"
        >
        {{/if}}
            {{for.each($components as $component)}}
            {{$require.basename = $component|uppercase.first.sentence:'.'}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </tr>
        {{$nr++}}
        {{/for.each}}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="{{array.count($components)}}" class="text-end">
                <span class="page">1-30 of 100</span>
                <i class="fas fa-chevron-circle-left"></i>
                <i class="fas fa-chevron-circle-right"></i>
            </td>
        </tr>
        </tfoot>
    </table>
    {{/if}}
</div>