{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
<form
    name="settings-email-settings-form"
    method="post"
    data-url="{{server.url('core')}}Settings/Email/Add/"
    data-url-error="{{route.get(route.prefix() + '-settings-email-add-body')}}"
>
    {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Error.tpl')}}
    <div class="mb-3">
        {{if(
        is.empty($request.error.host) ||
        $request.error.host.validate_string_length.0 === true
        )}}
        {{$class = 'form-control'}}
        {{else}}
        {{$class = 'form-control alert-danger'}}
        {{/if}}
        <input
            id="settings-email-host"
            class="{{$class}}"
            type="text"
            name="host"
            value="{{$request.host}}"
            placeholder="Host*"
        /><br>
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
            name="port"
            value="{{$request.port}}"
            placeholder="Port*"
        /><br>
        <input
            id="settings-email-from-name"
            class="form-control"
            type="text"
            name="from_name"
            value="{{$request.from_name}}"
            placeholder="From name"
        /><br>
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
            name="from_email"
            value="{{$request.from_email}}"
            placeholder="From e-mail*"
        /><br>
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
            name="username"
            value="{{$request.username}}"
            placeholder="Username*"
        /><br>
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
        <input
            id="settings-email-password"
            class="{{$class}}"
            type="password"
            name="password"
            value="{{$request.password}}"
            placeholder="Password*"
        /><br>
    </div>
    <div class="mb-3">
        <button
            type="submit"
            class="btn btn-primary"
        >
            Add
        </button>
    </div>
</form>