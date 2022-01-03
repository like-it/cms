{R3M}
{{$i.icon = __('settings.email.section.settings.body.component.options.edit.icon')}}
<i
    class="{{$i.icon}} settings-email-settings-edit"
    data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
    data-frontend-url="{{route.get(route.prefix() + '-settings-email-edit-body')}}"
>
</i>