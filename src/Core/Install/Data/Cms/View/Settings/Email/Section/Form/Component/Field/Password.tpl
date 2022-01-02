{R3M}
{{if(
is.empty($request.error.password) ||
(
$request.error.password.validate_string_length.0 === true &&
$request.error.password.validate_string_has_number.0 === true &&
$request.error.password.validate_string_has_uppercase.0 === true &&
$request.error.password.validate_string_has_lowercase.0 === true &&
$request.error.password.validate_string_has_symbol.0 === true
)
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