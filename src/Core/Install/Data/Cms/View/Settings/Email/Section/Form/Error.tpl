{R3M}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{if($request.error.from_email.validate_is_email.0 === false)}}
    The From e-mail should be an e-mail address.<br>
{{/if}}
{{if($request.error.host.validate_string_length.0 === false)}}
    The Host should consist of 3 characters minimum.<br>
{{/if}}
{{if($request.error.port.validate_string_has_number.0 === false)}}
    The Port should be a number between 1 - 65535.<br>
{{/if}}
{{if($request.error.username.validate_string_length.0 === false)}}
    The username is required.<br>
{{/if}}
{{if($request.error.password.validate_string_length.0 === false)}}
    The password should be at least 8 characters long.<br>
{{/if}}
{{if($request.error.password.validate_string_has_number.0 === false)}}
    The password should contain a number.<br>
{{/if}}
{{if($request.error.password.validate_string_has_uppercase.0 === false)}}
    The password should contain an uppercase character.<br>
{{/if}}
{{if($request.error.password.validate_string_has_lowercase.0 === false)}}
    The password should contain a lowercase character.<br>
{{/if}}
{{if($request.error.password.validate_string_has_symbol.0 === false)}}
    The password should contain a symbol character.<br>
    {literal}
     Valid symbols are: ` ~ ! @ # $ % ^ & * ( ) - _ + = { } [ ] ; : ' " | ? \ / < > , .<br>
     {/literal}
{{/if}}
{{if(!is.empty($request.error))}}
        </p>
    </div>
{{/if}}