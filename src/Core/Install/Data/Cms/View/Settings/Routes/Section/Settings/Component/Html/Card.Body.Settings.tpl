{{R3M}}
{{$components = [
'subdomain',
'host',
'extension',
'theme',
'default',
'options'
]}}
{{$options = [
'edit',
'component',
'controller',
'default',
'module',
'node',
'route',
'script',
'stylesheet',
'template',
'visit',
'delete'
]}}
<div class="card-body h-100 card-body-{{$command}}">
    {{if(!is.empty($request.nodeList))}}
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            {{for.each($components as $component)}}
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.' + $__.subcommand + '.component.thead.' + $component)}}</th>
            {{/for.each}}
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $uuid => $node)}}
        <tr

            data-url="{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$uuid}}"
            data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-body')}}"
        >
            {{for.each($components as $component)}}
            {{$require.basename = $component|uppercase.first.sentence:'.'}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </tr>
        {{/for.each}}
        </tbody>
    </table>
    {{/if}}
</div>