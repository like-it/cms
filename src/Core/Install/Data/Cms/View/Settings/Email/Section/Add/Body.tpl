{R3M}
{{if($request.error)}}
{{/if}}
{{if($is.add.body)}}
    {{$section.name = 'main-content'}}
    {{$section.title = 'Main-content'}}
    {{$request.method = 'replace-with-or-append-to'}}
    {{$request.target = 'section[name="' + $section.name + '"] .card-body-add'}}
    {{$request.append.to = 'section[name="' + $section.name + '"] .card'}}
{{/if}}
{{script('module')}}
    {{require($controller.dir.view + $controller.title + '/Email/Module/Add.js')}}
{{/script}}
<div class="card-body h-100 card-body-add" data-menu=".settings-email-add">
    <form
        name="settings-email-settings-form"
        method="post"
        data-url="{{server.url('core')}}Settings/Email/Add/"
        data-url-error="{{route.get(route.prefix() + '-settings-email-add-body')}}"
    >
        {{if(!is.empty($request.error))}}
            <div class="mb-3">
                <p class="alert alert-danger">
        {{/if}}

        {{if($request.error.host.validate_string_length.0 === false)}}
            The Host should consist of 3 characters minimum.<br>
        {{/if}}
        {{if($request.error.port.validate_string_has_number.0 === false)}}
            The Port should be a number between 1 - 65536.<br>
        {{/if}}
        {{if($request.error.from_email.validate_is_email.0 === false)}}
            The From e-mail should be an e-mail address.<br>
        {{/if}}
        {{if($request.error.username.validate_string_length.0 === false)}}
            The username is required.<br>
        {{/if}}

        {{if($request.error.password.validate_string_length.0 === false)}}
            The password should be at least 8 characters long.<br>
        {{/if}}
        {{if($request.error.password.validate_string_has_number.0 === false)}}
            The password should contain a number.<br>
        {{/if}}
        {{if($request.error.password.validate_string_has_uppercase.0 === false)}}
            The password should contain an uppercase character.<br>
        {{/if}}
        {{if($request.error.password.validate_string_has_lowercase.0 === false)}}
            The password should contain a lowercase character.<br>
        {{/if}}

        {{if($request.error.password.validate_string_has_symbol.0 === false)}}
            The password should contain a symbol character.<br>
            {literal}
             Valid symbols are ` ~ ! @ # $ % ^ & * ( ) - _ + = { } [ ] ; : ' " | ? \ / < > , .<br>
             {/literal}
        {{/if}}

        {{if(!is.empty($request.error))}}
            </p>
            </div>
        {{/if}}
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
            class="btn btn-primary">
            Add
        </button>
        </div>
    </form>
</div>