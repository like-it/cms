{{R3M}}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{$errors = [
'module.validate_string_length',
'module.validate_string_contains',
'submodule.validate_string_contains',
'command.validate_string_contains',
'subcommand.validate_string_contains',
'method[].validate_in_list_json',
'name.validate_is_unique_json',
'redirect.validate_string_length',
'redirect.validate_string_contains',
]}}
{{for.each($errors as $error)}}
    {{if(request.error($error) === true)}}
        {{__($__.module + '.' + $__.submodule + '.section.form.error.' + $error)}}<br>
    {{/if}}
{{/for.each}}
{{if(!is.empty($request.error))}}
        </p>
    </div>
{{/if}}