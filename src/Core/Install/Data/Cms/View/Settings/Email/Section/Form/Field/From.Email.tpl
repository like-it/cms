{R3M}
{{if(
is.empty($request.error.from_email) ||
$request.error.from_email.validate_is_email.0 === true
)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{/if}}
<input
    id="settings-email-from-email"
    class="{{$class}}"
    type="text"
    name="node.from_email"
    value="{{$request.node.from_email}}"
    placeholder="From e-mail*"
/><br>