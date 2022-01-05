{{R3M}}
{{if($init === true)}}
{{require($prefix + 'Init.tpl')}}
{{/if}}
{{if(is.empty($subcommand))}}
{{$subcommand = 'content'}}
{{/if}}
{{$__.module = $module|lowercase|replace:'-':'.'}}
{{$__.submodule = $submodule|lowercase|replace:'-':'.'}}
{{$__.command = $command|lowercase|replace:'-':'.'}}
{{$__.subcommand = $subcommand|lowercase|replace:'-':'.'}}
{{$require.module = $module|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.command = $command|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.subcommand = $subcommand|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{if(!is.empty($debug))}}
    {{dd('{{$this}}')}}
{{else}}
    {{if(
        !is.empty($submodule) &&
        !is.empty($command)
    )}}
        {{require($prefix + $require.submodule + '/Section/' + $require.command +'/' + $require.subcommand + '.tpl')}}
        {{if($script === 'module')}}
            {{$script = []}}
            {{script('module')}}
            {{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
            {{/script}}
        {{/if}}
    {{else.if(
        is.empty($submodule) &&
        !is.empty($command)
    )}}
        {{require($prefix + '/Section/' + $require.command +'/' + $require.subcommand + '.tpl')}}
        {{if($script === 'module')}}
            {{$script = []}}
            {{script('module')}}
            {{require($prefix + '/Module/' + $require.command + '.js')}}
        {{/script}}
        {{/if}}
    {{/if}}
{{/if}}

