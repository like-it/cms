{R3M}
<div class="card-body h-100">
    <form
        name="settings-email-settings-form"
        method="post"
        data-url="{{server.url('core')}}Settings/Email/Add/"
        data-frontend-url="{{route.get(route.prefix()+ '-settings-email-settings')}}"
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
                class="form-control"
                type="text"
                name="host"
                value="{{$request.host}}"
                placeholder="Host"
            /><br>
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
                class="form-control"
                type="text"
                name="port"
                value="{{$request.port}}"
                placeholder="Port"
            /><br>
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