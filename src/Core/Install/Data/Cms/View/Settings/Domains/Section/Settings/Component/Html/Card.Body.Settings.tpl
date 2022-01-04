{{R3M}}
{{$__.module = $module|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{$__.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{$__.command = $command|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{dd('{{$this}}')}}
<div class="card-body h-100 card-body-{{$command}}">
    {{if(!is.empty($request.nodeList))}}
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.thead.from.name')}}</th>
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.thead.from.email')}}</th>
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.thead.host')}}</th>
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.thead.port')}}</th>
            <th scope="col">{{__($__.module + '.' + $__.submodule + '.section.' + $__.command + '.component.thead.options')}}</th>
        </tr>
        </thead>
        <tbody>
        {{for.each($request.nodeList as $uuid => $node)}}
        <tr
            data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
            data-frontend-url="{{route.get(route.prefix() + '-settings-email-edit-body')}}"
        >
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/From.Name.tpl')}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/From.Email.tpl')}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/Host.tpl')}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/Port.tpl')}}
            {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Td/Options.tpl')}}
        </tr>
        {{/for.each}}
        </tbody>
    </table>
    {{/if}}
</div>