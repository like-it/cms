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
{{if($script === 'module')}}
{{$script = []}}
{{script('module')}}
{{require($prefix + $require.submodule + '/Module/' + $require.command + '.js')}}
{{/script}}
{{/if}}
{{require($prefix + $require.submodule + '/Section/' + $require.command +'/Content.tpl')}}
{{else.if(
!is.empty($command)
)}}
{{$require.command = $command|uppercase.first.sentence:'-'|replace:'-':'/'}}
{{if($script === 'module')}}
{{$script = []}}
{{script('module')}}
{{require($prefix + '/Module/' + $require.command + '.js')}}
{{/script}}
{{/if}}
{{require($prefix + '/Section/' + $require.command +'/Content.tpl')}}
{{/if}}

