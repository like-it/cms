{R3M}
{{if($init === true)}}
{{require($prefix + 'Init.tpl')}}
{{/if}}
{{dd('$this')}}
{{if(
!is.empty($submodule) &&
!is.empty($command)
)}}
{{$require.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.command = $command|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{if($script.module === true)}}
{{script('module')}}
{{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
{{/script}}
{{/if}}
{{/if}}
{{require($prefix + 'Export/Section/Main/Content.tpl')}}
