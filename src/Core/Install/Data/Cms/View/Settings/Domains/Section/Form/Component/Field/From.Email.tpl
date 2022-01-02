{R3M}
{{if(request.error('from_email.validate_is_email') === false)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{if(is.empty($request.focus))}}
{{$request.focus = 'node.from_email'}}
{{/if}}
{{/if}}
<label for="settings-email-from-email">From e-mail*</label>
<input
    id="settings-email-from-email"
    class="{{$class}}"
    type="text"
    name="node.from_email"
    value="{{$request.node.from_email}}"
    placeholder="From e-mail*"
/><br>