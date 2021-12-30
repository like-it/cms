{R3M}
{{$li.name = 'account-settings'}}
{{$li.target = $li.name|replace:'-':'.'}}
{{$li.id = 'accordion-flush-' + $li.name}}
{{$li.flush.heading.1 = 'flush-heading-one-' + $li.name}}
{{$li.flush.collapse.1 = 'flush-collapse-one-' + $li.name}}
{{$li.title = __('settings.main.component.body.li.' + $li.target +'.title')}}
{{$li.description = __('settings.main.component.body.li.' + $li.target + '.body')}}
{{require($controller.dir.view + $controller.title + '/Main/Element/Li/Accordion.Flush.tpl')}}