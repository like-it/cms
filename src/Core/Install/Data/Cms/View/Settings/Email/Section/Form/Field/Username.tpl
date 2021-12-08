{R3M}
{{if(
is.empty($request.error.username) ||
$request.error.username.validate_string_length.0 === true
)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{/if}}
<input
    id="settings-email-username"
    class="{{$class}}"
    type="text"
    name="node.username"
    value="{{$request.node.username}}"
    placeholder="Username*"
/><br>