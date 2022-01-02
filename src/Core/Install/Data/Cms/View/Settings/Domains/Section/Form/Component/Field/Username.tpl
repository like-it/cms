{R3M}
{{if(request.error('username.validate_string_length') === false)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{if(is.empty($request.focus))}}
{{$request.focus = 'node.username'}}
{{/if}}
{{/if}}
<label for="settings-email-from-username">Username*</label>
<input
    id="settings-email-username"
    class="{{$class}}"
    type="text"
    name="node.username"
    value="{{$request.node.username}}"
    placeholder="Username*"
/><br>