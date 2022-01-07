{{R3M}}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{$errors = [
'extension.validate_string_length',
'host.validate_string_length',
'host.validate_string_contains',
'theme.validate_in_array',
'name.validate_is_unique_json'
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