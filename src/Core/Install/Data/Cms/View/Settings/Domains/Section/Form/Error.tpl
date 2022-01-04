{R3M}
{{if(!is.empty($request.error))}}
    <div class="mb-3">
        <p class="alert alert-danger">
{{/if}}
{{$__.module = $module|lowercase|replace:'-':'.'}}
{{$__.submodule = $submodule|lowercase|replace:'-':'.'}}
{{$__.command = $command|lowercase|replace:'-':'.'}}
{{$request.error = [
'extension.validate_string_length',
'host.validate_string_length',
'theme.validate_in_array',
'name.validate_is_unique_json'
]}}
{{for.each($request.error as $error)}}
    {{if(request.error($error) === true)}}
        {{__($__.module + '.' + $__.submodule + '.form.' + $error)}}<br>
    {{/if}}
{{/for.each}}
{{if(!is.empty($request.error))}}
        </p>
    </div>
{{/if}}