{{R3M}}
{{if($init === true)}}
{{require($prefix + 'Init.tpl')}}
{{/if}}
{{if(is.empty($subcommand))}}
{{$subcommand = 'content'}}
{{/if}}
{{$language = language()}}
{{$__.module = $module|lowercase|replace:'-':'.'}}
{{$__.submodule = $submodule|lowercase|replace:'-':'.'}}
{{$__.command = $command|lowercase|replace:'-':'.'}}
{{$__.subcommand = $subcommand|lowercase|replace:'-':'.'}}
{{$require.module = $module|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.command = $command|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.subcommand = $subcommand|uppercase.first.sentence:'-'|replace:'-':'.'}}
{{$require.language = $language|uppercase.first}}
{{if(!is.empty($debug))}}
    {{dd('{{$this}}')}}
{{else}}
    {{if(
        !is.empty($submodule) &&
        !is.empty($command)
    )}}
        {{require($prefix + $require.submodule + '/Section/' + $require.command +'/' + $require.subcommand + '.tpl')}}
    {{else.if(
        is.empty($submodule) &&
        !is.empty($command)
    )}}
        {{require($prefix + '/Section/' + $require.command +'/' + $require.subcommand + '.tpl')}}
    {{/if}}
{{/if}}

