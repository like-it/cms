{R3M}
{{if(
is.empty($request.error.port) ||
$request.error.port.validate_string_has_number.0 === true
)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{/if}}
<input
    id="settings-email-port"
    class="{{$class}}"
    type="text"
    name="node.port"
    value="{{$request.node.port}}"
    placeholder="Port*"
/><br>