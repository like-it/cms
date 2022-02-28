{{R3M}}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{$errors = [
'url.validate_string_length',
'url.validate_string_contains',
'url.validate_url',
'extension.validate_string_length',
'extension.validate_in_array',
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