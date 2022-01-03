{R3M}
{{$i.icon = __('settings.email.section.settings.body.component.options.delete.icon')}}
<i
    class="{{$i.icon}} settings-email-settings-delete"
    data-url="{{server.url('core')}}Settings/Email/{{$uuid}}"
    data-request-method="DELETE"
    data-name="{{$node.from_email}}"
>
</i>