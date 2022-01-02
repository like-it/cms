{R3M}
{{if(request.error('host.validate_string_length') === false)}}
{{$class = 'form-control'}}
{{else}}
{{$class = 'form-control alert-danger'}}
{{if(is.empty($request.focus))}}
{{$request.focus = 'node.host'}}
{{/if}}
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