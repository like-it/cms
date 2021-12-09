{R3M}
{{if(!is.empty($node.isDefault))}}
    <i class="fas fa-award settings-email-settings-is-default" title="Default account"></i>
{{else}}
    <i
        class="fas fa-sign-out-alt settings-email-account-default"
        title="Make default account"
        data-url="{{server.url('core')}}Settings/Email/Account/Default/{{$uuid}}"
    >
    </i>
{{/if}}