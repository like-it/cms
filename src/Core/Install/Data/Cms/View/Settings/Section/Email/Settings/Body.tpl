{R3M}
<div class="card-body h-100">
    <form
        name="settings-email-settings-form"
        method="post"
        data-url="{{server.url('core')}}Settings/Email/Add/"
    >
        <div class="mb-3">
            <label
                for="settings-email-host"
                class="form-label"
            >
                Host:
            </label>
            <input
                id="settings-email-host"
                class="form-control"
                type="text"
                name="host"
                value="{{$request.host}}"
            /><br>
        </div>
        <div class="mb-3">
            <label
                for="settings-email-port"
                class="form-label"
            >
                Port:
            </label>
            <input
                id="settings-email-port"
                class="form-control"
                type="text"
                name="port"
                value="{{$request.port}}"
            /><br>
        </div>
        <div class="mb-3">
            <label
                for="settings-email-from"
                class="form-label"
            >
                From:
            </label>
            <input
                id="settings-email-from"
                class="form-control"
                type="text"
                name="from"
                value="{{$request.from}}"
            /><br>
        </div>
        <div class="mb-3">
            <label
                for="settings-email-username"
                class="form-label"
            >
                Username:
            </label>
            <input
                id="settings-email-username"
                class="form-control"
                type="text"
                name="username"
                value="{{$request.username}}"
            /><br>
        </div>
        <div class="mb-3">
            <label
                for="settings-email-password"
                class="form-label"
            >
                Password:
            </label>
            <input
                id="settings-email-password"
                class="form-control"
                type="text"
                name="password"
                value="{{$request.password}}"
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