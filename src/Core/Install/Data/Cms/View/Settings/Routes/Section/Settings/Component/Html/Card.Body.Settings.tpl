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
        {{$page.current = 1}}
        {{$page.size = 2}}
        {{$page.start = ($page.current * $page.size) - $page.size}}
        {{$page.start += 1}}
        {{$page.to = ($page.current * $page.size)}}
        {{if($request.count < $page.to)}}
            {{$page.to = $request.count}}
        {{/if}}
        {{$page.count = $request.count}}
        {{$page.previous = $page.current - 1}}
        {{if($page.previous < 1)}}
            {{$page.previous = 1}}
        {{/if}}
        {{$page.next = $page.current + 1}}
        {{$page.max = math.ceil($page.count / $page.size)}}
        {{if($page.next > $page.max)}}
            {{$page.next = $page.max}}
        {{/if}}
        <tfoot>
        <tr>
            <td colspan="{{array.count($components)}}" class="text-end">
                <span class="page">{{$page.start}}-{{$page.to}} of {{$page.count}}</span>
                {{if($page.current === 1)}}
                {{$i.class = 'fas fa-angle-double-left disabled'}}
                {{$i.data.url = ''}}
                {{$i.data.frontend.url = ''}}
                {{else}}
                {{$i.class = 'fas fa-angle-double-left'}}
                {{$i.data.url =
                server.url('core') +
                $require.module +
                '/' +
                $require.submodule +
                '/' +
                $require.command +
                '/' +
                '{node.domain}' +
                '/?page=1'
                }}
                {{$i.data.frontend.url =
                route.get(route.prefix() +
                '-' +
                $module +
                '-' +
                $submodule +
                '-' +
                $command +
                '-body'
                )}}
                {{/if}}
                <button class="btn btn-primary">
                    <i
                        class="{{$i.class}}"
                        data-url="{{$i.data.url}}"
                        data-frontend-url="{{$i.data.frontend.url}}"
                    >
                    </i>
                </button>
                {{if($page.current === 1)}}
                {{$i.class = 'fas fa-angle-left disabled'}}
                {{$i.data.url = ''}}
                {{$i.data.frontend.url = ''}}
                {{else}}
                {{$i.class = 'fas fa-angle-left'}}
                {{$i.data.url =
                server.url('core') +
                $require.module +
                '/' +
                $require.submodule +
                '/' +
                $require.command +
                '/' +
                '{node.domain}' +
                '/?page=' +
                $page.previous
                }}
                {{$i.data.frontend.url =
                route.get(route.prefix() +
                '-' +
                $module +
                '-' +
                $submodule +
                '-' +
                $command +
                '-body'
                )}}
                {{/if}}
                <button class="btn btn-primary">
                    <i
                        class="{{$i.class}}"
                        data-url="{{$i.data.url}}"
                        data-frontend-url="{{$i.data.frontend.url}}"
                    >
                    </i>
                </button>
                {{if($page.current === $page.max)}}
                {{$i.class = 'fas fa-angle-right disabled'}}
                {{$i.data.url = ''}}
                {{$i.data.frontend.url = ''}}
                {{else}}
                {{$i.class = 'fas fa-angle-right'}}
                {{$i.data.url =
                server.url('core') +
                $require.module +
                '/' +
                $require.submodule +
                '/' +
                $require.command +
                '/' +
                '{node.domain}' +
                '/?page=' +
                $page.next
                }}
                {{$i.data.frontend.url =
                route.get(route.prefix() +
                '-' +
                $module +
                '-' +
                $submodule +
                '-' +
                $command +
                '-body'
                )}}
                {{/if}}
                <button class="btn btn-primary">
                    <i
                        class="{{$i.class}}"
                        data-url="{{$i.data.url}}"
                        data-frontend-url="{{$i.data.frontend.url}}"
                    >
                    </i>
                </button>
                {{if($page.current === $page.max)}}
                {{$i.class = 'fas fa-angle-double-right disabled'}}
                {{$i.data.url = ''}}
                {{$i.data.frontend.url = ''}}
                {{else}}
                {{$i.class = 'fas fa-angle-double-right'}}
                {{$i.data.url =
                    server.url('core') +
                    $require.module +
                    '/' +
                    $require.submodule +
                    '/' +
                    $require.command +
                    '/' +
                    '{node.domain}' +
                    '/?page=' +
                    $page.max
                }}
                {{$i.data.frontend.url =
                    route.get(route.prefix() +
                    '-' +
                    $module +
                    '-' +
                    $submodule +
                    '-' +
                    $command +
                    '-body'
                )}}
                {{/if}}
                <button class="btn btn-primary">
                    <i
                        class="{{$i.class}}"
                        data-url="{{$i.data.url}}"
                        data-frontend-url="{{$i.data.frontend.url}}"
                    >
                    </i>
                </button>
            </td>
        </tr>
        </tfoot>
    </table>
    {{/if}}
</div>