{R3M}
{{if(
is.empty($request.error.host) ||
$request.error.host.validate_string_length.0 === true
)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{/if}}
<label for="settings-email-from-host">Host*</label>
<input
    id="settings-email-host"
    class="{{$class}}"
    type="text"
    name="node.host"
    value="{{$request.node.host}}"
    placeholder="Host*"
/><br>