{R3M}
{{if(request.error('port.validate_string_has_number') === false)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{/if}}
<label for="settings-email-from-port">Port*</label>
<input
    id="settings-email-port"
    class="{{$class}}"
    type="text"
    name="node.port"
    value="{{$request.node.port}}"
    placeholder="Port*"
/><br>