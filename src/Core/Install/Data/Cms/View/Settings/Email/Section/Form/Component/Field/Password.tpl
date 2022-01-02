{R3M}
{{if(
request.error('password.validate_string_length') === false &&
request.error('password.validate_string_has_number') === false &&
request.error('password.validate_string_has_uppercase') === false &&
request.error('password.validate_string_has_lowercase') === false &&
request.error('password.validate_string_has_symbol') === false
)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{/if}}
<label for="settings-email-from-password">Password*</label>
<input
    id="settings-email-password"
    class="{{$class}}"
    type="password"
    name="node.password"
    value="{{$request.node.password}}"
    placeholder="Password*"
/><br>