{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{script('module')}}
import user from "/Module/User.js"
ready(() => {
    if(user.token()){
        console.log(user.token());
        //validate token and get user
    } else {
        if(user.refreshToken()){
            //validate refresh token and get user with new token
        } else {
            //redirect user login
            redirect("{{route.get(route.prefix() + '-user-login')}}");
        }
    }
});
{{/script}}
{{$request.method = 'replace'}}
{{$request.target = 'body'}}

Under construction... <br>
Greetings from Core Install Data.<br>