{{R3M}}
{{if(!is.empty($request.page))}}
{{$page.current = (int) $request.page}}
{{else}}
{{$page.current = 1}}
{{/if}}
{{$page.size = 12}}
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
        {{$td.colspan = array.count($components) - 2}}
        <td colspan="{{$td.colspan}}">
        </td>
        <td class="text-end">
            <form
                class="d-flex"
                data-url="{{server.url('core')}}Settings/Views/Settings/{node.domain}"
                data-frontend-url="{{route.get(route.prefix() + '-settings-views-settings-body')}}"
                name="search"
                >
                <input
                    class="form-control me-2"
                    type="search"
                    placeholder="Search..."
                    aria-label="Search"
                    name="q"
                    value="{{$request.q}}"
                >
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </td>
        <td class="text-end">
            <span class="page">{{$page.start}}-{{$page.to}} of {{$page.count}}</span>
            {{if($page.current === 1)}}
            {{$i.class = 'fas fa-angle-double-left'}}
            {{$button.class = 'btn btn-primary disabled'}}
            {{$button.data.url = ''}}
            {{$button.data.frontend.url = ''}}
            {{else}}
            {{$i.class = 'fas fa-angle-double-left'}}
            {{$button.class = 'btn btn-primary'}}
            {{$button.data.url =
            server.url('core') +
            $require.module +
            '/' +
            $require.submodule +
            '/' +
            $require.command +
            '/' +
            '{node.domain}' +
            '/?page=1' +
            '&q=' +
            $request.q
            }}
            {{$button.data.frontend.url =
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
            <button
                class="{{$button.class}}"
                data-url="{{$button.data.url}}"
                data-frontend-url="{{$button.data.frontend.url}}"
                data-page="1"
            >
                <i
                    class="{{$i.class}}"
                >
                </i>
            </button>
            {{if($page.current === 1)}}
            {{$i.class = 'fas fa-angle-left'}}
            {{$button.class = 'btn btn-primary disabled'}}
            {{$button.data.url = ''}}
            {{$button.data.frontend.url = ''}}
            {{else}}
            {{$i.class = 'fas fa-angle-left'}}
            {{$button.class = 'btn btn-primary'}}
            {{$button.data.url =
            server.url('core') +
            $require.module +
            '/' +
            $require.submodule +
            '/' +
            $require.command +
            '/' +
            '{node.domain}' +
            '/?page=' +
            $page.previous +
            '&q=' +
            $request.q
            }}
            {{$button.data.frontend.url =
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
            <button
                class="{{$button.class}}"
                data-url="{{$button.data.url}}"
                data-frontend-url="{{$button.data.frontend.url}}"
                data-page="{{$page.previous}}"
            >
                <i
                    class="{{$i.class}}"
                >
                </i>
            </button>
            {{if($page.current == $page.max)}}
            {{$i.class = 'fas fa-angle-right'}}
            {{$button.class = 'btn btn-primary disabled'}}
            {{$button.data.url = ''}}
            {{$button.data.frontend.url = ''}}
            {{else}}
            {{$i.class = 'fas fa-angle-right'}}
            {{$button.class = 'btn btn-primary'}}
            {{$button.data.url =
            server.url('core') +
            $require.module +
            '/' +
            $require.submodule +
            '/' +
            $require.command +
            '/' +
            '{node.domain}' +
            '/?page=' +
            $page.next +
            '&q=' +
            $request.q
            }}
            {{$button.data.frontend.url =
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
            <button
                class="{{$button.class}}"
                data-url="{{$button.data.url}}"
                data-frontend-url="{{$button.data.frontend.url}}"
                data-page="{{$page.next}}"
            >
                <i
                    class="{{$i.class}}"
                >
                </i>
            </button>
            {{if($page.current == $page.max)}}
            {{$i.class = 'fas fa-angle-double-right'}}
            {{$button.class = 'btn btn-primary disabled'}}
            {{$button.data.url = ''}}
            {{$button.data.frontend.url = ''}}
            {{else}}
            {{$i.class = 'fas fa-angle-double-right'}}
            {{$button.class = 'btn btn-primary'}}
            {{$button.data.url =
                server.url('core') +
                $require.module +
                '/' +
                $require.submodule +
                '/' +
                $require.command +
                '/' +
                '{node.domain}' +
                '/?page=' +
                $page.max +
                '&q=' +
                $request.q
            }}
            {{$button.data.frontend.url =
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
            <button
                class="{{$button.class}}"
                data-url="{{$button.data.url}}"
                data-frontend-url="{{$button.data.frontend.url}}"
                data-page="{{$page.max}}"
            >
                <i
                    class="{{$i.class}}"
                >
                </i>
            </button>
        </td>
    </tr>
</tfoot>