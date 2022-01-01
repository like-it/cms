{{if($init === true)}}
{{require($prefix + 'Init.tpl')}}
{{/if}}
{{if($script.module === true)}}
{{script('module')}}
{{require($prefix + 'Export/Module/Main.js')}}
{{/script}}
{{/if}}
{{require($prefix + 'Export/Section/Main/Content.tpl')}}
