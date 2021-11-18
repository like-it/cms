{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{script('module')}}
import user from "/Module/User.js";
ready(() => {
    if(user.token()){
        console.log('token: ' + user.token());
        const url = "{{server.url('core')}}User/Current/";
        const data = {
            "token" : user.token()
        };
        header('authorization', 'Bearer ' + user.token());
        request(url, null, (url, response) => {
            console.log(response);
        });
        //validate token and get user
    } else {
        if(user.refreshToken()){
            console.log('refreshToken: ' + user.refreshToken());
            const url = "{{server.url('core')}}User/Refresh/Token/";
            const data = {
                "refreshToken" : user.refreshToken()
            };
            request(url, data, (url, response) => {
                //should get new token | refreshToken
                if(response?.user?.token){
                    user.token(response.user.token);
                }
                if(response?.user?.refreshToken){
                    user.refreshToken(response.user.refreshToken);
                }
                console.log(response);
            });
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