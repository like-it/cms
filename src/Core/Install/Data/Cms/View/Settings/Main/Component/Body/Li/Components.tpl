{{R3M}}
{{$li.name = 'components'}}
{{$li.translation = $li.name|replace:'-':'.'}}
{{$li.id = 'accordion-flush-' + $li.name}}
{{$li.flush.heading.1 = 'flush-heading-one-' + $li.name}}
{{$li.flush.collapse.1 = 'flush-collapse-one-' + $li.name}}
{{$li.title = __('settings.main.component.body.li.' + $li.translation +'.title')}}
{{$li.description = __('settings.main.component.body.li.' + $li.translation + '.body')}}
{{require($controller.dir.view + $controller.title + '/Main/Component/Body/Accordion.Flush.tpl')}}