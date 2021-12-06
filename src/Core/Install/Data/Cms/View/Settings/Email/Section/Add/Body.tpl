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
        <div class="mb-3">
            /*
            <label
                for="settings-email-host"
                class="form-label"
            >
                Host:
            </label>
            */
            <input
                id="settings-email-host"
                {{if($request.error.host.validate_string_length.0 === false)}}
                class="form-control"
                {{else}}
                class="form-control error error-host"
                {{/if}}
                type="text"
                name="host"
                value="{{$request.host}}"
                placeholder="Host"
            /><br>
            {{if($request.error.host.validate_string_length.0 === false)}}
                <span class="error error-host validate-string-length">
                    Minimum 3 characters required.
                </span>
            {{/if}}
        </div>
        <div class="mb-3">
            /*
            <label
                for="settings-email-port"
                class="form-label"
            >
                Port:
            </label>
            */
            <input
                id="settings-email-port"
                {{if($request.error.port.validate_string_has_number.0 === false)}}
                class="form-control"
                {{else}}
                class="form-control error error-host"
                {{/if}}
                type="text"
                name="port"
                value="{{$request.port}}"
                placeholder="Port"
            /><br>
            {{if($request.error.port.validate_string_has_number.0 === false)}}
                <span class="error error-host validate-string-has-number">
                    The port should be a number.
                </span>
            {{/if}}
        </div>
        <div class="mb-3">
            /*
            <label
                for="settings-email-from-name"
                class="form-label"
            >
                From name:
            </label>
            */
            <input
                id="settings-email-from-name"
                class="form-control"
                type="text"
                name="from.name"
                value="{{$request.from.name}}"
                placeholder="From name"
            /><br>
        </div>
        <div class="mb-3">
            /*
            <label
                for="settings-email-from-email"
                class="form-label"
            >
                From e-mail:
            </label>
            */
            <input
                id="settings-email-from-email"
                class="form-control"
                type="text"
                name="from.email"
                value="{{$request.from.email}}"
                placeholder="From e-mail"
            /><br>
        </div>
        <div class="mb-3">
            /*
            <label
                for="settings-email-username"
                class="form-label"
            >
                Username:
            </label>
            */
            <input
                id="settings-email-username"
                class="form-control"
                type="text"
                name="username"
                value="{{$request.username}}"
                placeholder="Username"
            /><br>
        </div>
        <div class="mb-3">
            /*
            <label
                for="settings-email-password"
                class="form-label"
            >
                Password:
            </label>
            */
            <input
                id="settings-email-password"
                class="form-control"
                type="password"
                name="password"
                value="{{$request.password}}"
                placeholder="Password"
            />
            <br>
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