{R3M}
{{if(!is.empty($node.isDefault))}}
    {{$i.icon = __('settings.email.section.settings.body.component.options.default.icon')}}
    {{$i.title = __('settings.email.section.settings.body.component.options.default.title')}}
    <i
        class="{{$i.icon}} settings-email-settings-is-default"
        title="{{$i.title}}"
    >
    </i>
{{else}}
    {{$i.icon = __('settings.email.section.settings.body.component.options.default.action.icon')}}
    {{$i.title = __('settings.email.section.settings.body.component.options.default.action.title')}}
    <i
        class="{{$i.icon}} settings-email-account-default"
        title="{{$i.title}}"
        data-url="{{server.url('core')}}Settings/Email/Account/Default/{{$uuid}}"
    >
    </i>
{{/if}}