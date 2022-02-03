{{R3M}}
{{$components = [
'actions',
'name',
'url',
'routes',
'functions',
'options'
]}}
{{$options = [
'edit',
'view',
'rename',
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
        {{for.each($request.nodeList as $node_nr => $node)}}
            {{$count++}}
        {{/for.each}}
        {{for.each($request.nodeList as $node_nr => $node)}}
            <tr
                data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.name}}/{{$node.domain}}"
                data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-controller-body')}}"
            >
            {{for.each($components as $component)}}
            {{$require.basename = $component|uppercase.first.sentence:'.'}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </tr>
        {{$nr++}}
        {{/for.each}}
        </tbody>
        {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Html/Pager.tpl')}}
    </table>
    {{/if}}
</div>