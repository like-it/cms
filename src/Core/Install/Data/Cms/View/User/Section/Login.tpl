{R3M}
<section name="user-login">
    <h1><i class="fas fa-sign-in-alt"></i>{{__('user.login.title')}}</h1>
    <div class="user-login">
        <form
                name="user_login"
                data-url="{{server.url('core')}}User/Login/Process/"
                method="post"
        >
            <label for="email"><i class="fas fa-user""></i></label>
            <input id="email" type="text" name="email" value="{{$request.email|default:''}}" placeholder="{{__('user.e-mail')}}"/><br>
            <label for="password"><i class="fas fa-key""></i></label>
            <input id="password" type="password" name="password" value="{{$request.password|default:''}}" placeholder="{{__('user.password')}}"/><br>
            <button
                    type="submit"
            >
                {{__('user.login')}}
            </button>
            <button
                    type="button"
                    class="password-forgot"
                    data-url="{{route.get(route.prefix() + '-user-password-forgot')}}"
                    data-target="section[name='user-login']"
                    data-method="replace-with"
            >
                {{__('user.password.forgot')}}
            </button><br>
            <span class="user-login-error"></span>
        </form>
        <p class="version">{{__('user.version')}}<small>{{config('version')}}</small></p>
    </div>
</section>