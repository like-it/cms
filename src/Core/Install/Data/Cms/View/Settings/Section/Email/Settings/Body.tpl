{R3M}
<div class="card-body h-100">
    <form
        name="settings-email-settings-form"
        method="post"
        data-url="{{}}"
    >
        <label for="settings-email-host">Host:</label>
        <input id="settings-email-host" type="text" name="host" value="{{$request.host}}" /><br>
        <label for="settings-email-port">Port:</label>
        <input id="settings-email-port" type="text" name="port" value="{{$request.port}}" /><br>
        <label for="settings-email-from">From:</label>
        <input id="settings-email-from" type="text" name="from" value="{{$request.from}}" /><br>
        <label for="settings-email-username">Username:</label>
        <input id="settings-email-username" type="text" name="username" value="{{$request.username}}" /><br>
        <label for="settings-email-password">Password:</label>
        <input  id="settings-email-password" type="text" name="password" value="{{$request.password}}" /><br>
    </form>
</div>