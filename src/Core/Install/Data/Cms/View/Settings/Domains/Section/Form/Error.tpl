{R3M}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{if(request.error('host.validate_string_length') === true)}}
    The domain should consist of 1 character minimum.<br>
{{/if}}
{{if(request.error('extension.validate_string_length') === true)}}
    The extension should consist of 1 character minimum.<br>
{{/if}}
{{if(request.error('theme.validate_in_array') === true)}}
    Please select a valid theme from the list.<br>
{{/if}}
{{if(request.error('name.validate_is_unique_json') === true)}}
    Please provide an unique name which consist of subdomain, domain & extension.<br>
{{/if}}
{{if(!is.empty($request.error))}}
        </p>
    </div>
{{/if}}