{{R3M}}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{$errors = [
'extension.validate_string_length',
'extension.validate_in_array',
'extension.validate_string_contains',
'name.validate_string_contains',
'url.validate_string_length',
'url.validate_url',
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