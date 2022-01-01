{R3M}
{{if($init === true)}}
{{require($prefix + 'Init.tpl')}}
{{/if}}

{{if(
!is.empty($submodule) &&
!is.empty($command)
)}}
{{$require.submodule = $submodule|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{$require.command = $command|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{dd('$this')}}
{{if($script === 'module')}}
{{script('module')}}
{{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
{{/script}}
{{/if}}
{{/if}}
{{require($prefix + 'Export/Section/Main/Content.tpl')}}
