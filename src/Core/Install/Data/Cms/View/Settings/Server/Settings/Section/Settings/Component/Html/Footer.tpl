{{R3M}}
{{if(!is.empty($request.page))}}
{{$page.current = (int) $request.page}}
{{else}}
{{$page.current = 1}}
{{/if}}
{{$page.size = $request.limit}}
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
        {{$td.colspan = array.count($components) - 1}}
        <td colspan="{{$td.colspan}}">
            <div class="btn-group">
                <div class="dropdown dropup">
                    <div class="btn-group">
                        <button
                            class="btn btn-outline-primary dropdown-toggle"
                            type="button"
                            data-toggle="dropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            {{__('settings.server.settings.section.settings.component.html.footer.actions.text')}}
                        </button>
                        <div
                            class="dropdown-menu"
                        >
                            {{for.each($actions as $action)}}
                                {{$require.basename = $action|uppercase.first.sentence:'.'}}
                                {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Actions/' + $require.basename + '.tpl')}}
                            {{/for.each}}
                        </div>
                    </div>
                </div>
                <div class="dropdown dropup">
                    <div class="btn-group">
                        <button
                            class="btn btn-outline-primary dropdown-toggle filter-type"
                            type="button"
                            data-toggle="dropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                        {{if($request.filter.type==='All')}}
                        {{__(
                        $__.module +
                        '.' +
                        $__.submodule +
                        '.section.' +
                        $__.command +
                        '.component.filter.all.text'
                        )}}
                        {{elseif($request.filter.type==='File')}}
                        {{__(
                        $__.module +
                        '.' +
                        $__.submodule +
                        '.section.' +
                        $__.command +
                        '.component.filter.file.text'
                        )}}
                        {{elseif($request.filter.type==='Dir')}}
                        {{__(
                        $__.module +
                        '.' +
                        $__.submodule +
                        '.section.' +
                        $__.command +
                        '.component.filter.dir.text'
                        )}}
                        {{else}}
                        {{__(
                        $__.module +
                        '.' +
                        $__.submodule +
                        '.section.' +
                        $__.command +
                        '.component.filter.file.text'
                        )}}
                        {{/if}}
                        </button>
                        <div
                            class="dropdown-menu"
                        >
                            {{for.each($filters as $filter)}}
                                {{$require.basename = $filter|uppercase.first.sentence:'.'}}
                                {{require($prefix + $require.submodule + '/Section/' + $require.command + '/Component/Filter/' + $require.basename + '.tpl')}}
                            {{/for.each}}
                        </div>
                    </div>
                </div>
            </div>
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
            '/?page=1' +
            '&q=' +
            $request.q +
            '&filter[type]=' +
            $request.filter.type
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
            '/?page=' +
            $page.previous +
            '&q=' +
            $request.q +
            '&filter[type]=' +
            $request.filter.type
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
            '/?page=' +
            $page.next +
            '&q=' +
            $request.q +
            '&filter[type]=' +
            $request.filter.type
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
                '/?page=' +
                $page.max +
                '&q=' +
                $request.q +
                '&filter[type]=' +
                $request.filter.type
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