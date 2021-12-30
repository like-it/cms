{R3M}
{{$li.name = 'components'}}
{{$li.id = 'accordion-flush-' + $li.name}}
{{$li.flush.heading.1 = 'flush-heading-one-' + $li.name}}
{{$li.flush.collapse.1 = 'flush-collapse-one-' + $li.name}}
{{$li.title = __('settings.main.component.body.li.' + $li.name +'.title')}}
{{$li.description = __('settings.main.component.body.li.' + $li.name + '.body')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/Li/Accordion.Flush.tpl')}}