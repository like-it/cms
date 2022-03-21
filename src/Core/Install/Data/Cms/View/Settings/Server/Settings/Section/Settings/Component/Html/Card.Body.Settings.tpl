{{R3M}}
{{$components = [
'actions',
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
'move',
'delete'
]}}
<div class="card-body h-100 card-body-{{$command}}">
    {{if(!is.empty($request.nodeList))}}
    <table class="table table-hover">
        <thead>
        <tr>
            {{for.each($components as $component)}}
            <th scope="col">
                {{if($component === 'actions')}}
                <input
                    type="checkbox"
                    name="node.checkInverse"
                    value="true"
                    title="{{__(
                    $__.module +
                    '.' +
                    $__.submodule +
                    '.section.' +
                    $__.command +
                    '.component.thead.' +
                    $component
                    )}}"
                />
                {{else}}
                {{__(
                $__.module +
                '.' +
                $__.submodule +
                '.section.' +
                $__.command +
                '.component.thead.' +
                $component
                )}}
                {{/if}}
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
            {{if(in.array(
                $node.extension,
                image.extensions()
            ))}}
            <tr
                data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.raw.encode}}/"
                data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-view-body')}}"
            >
            {{else}}
            <tr
                data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$node.url|url.raw.encode}}/"
                data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-template-body')}}"
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
        {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Html/Footer.tpl')}}
    </table>
    {{/if}}
</div>