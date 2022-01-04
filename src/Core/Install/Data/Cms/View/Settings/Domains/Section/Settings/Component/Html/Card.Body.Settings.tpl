{{R3M}}
{{$__.module = $module|lowercase|replace:'-':'.'}}
{{$__.submodule = $submodule|lowercase|replace:'-':'.'}}
{{$__.command = $command|lowercase|replace:'-':'.'}}
{{$data.module = $module|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$data.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$components = [
'subdomain',
'host',
'extension',
'options'
]}}
{{$options = [
'default',
'edit',
'delete'
]}}
<div class="card-body h-100 card-body-{{$command}}">
    {{if(!is.empty($request.nodeList))}}
    <table class="table">
        <thead>
        <tr>
            {{for.each($components as $component)}}
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.thead.' + $component)}}</th>
            {{/for.each}}
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $uuid => $node)}}
        <tr

            data-url="{{server.url('core') + $data.module + '/' + $data.submodule + '/'}}{{$uuid}}"
            data-frontend-url="{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-edit-' + $command)}}"
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