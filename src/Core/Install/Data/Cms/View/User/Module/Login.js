{R3M}

import login from "/User/Module/Login.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
ready(() => {

    require(
    [
    root() + 'User/Css/Login.css?' + version(),
    root() + 'User/Css/Password.Forgot.css?' + version(),
    root() + 'Debug/Css/Debug.css?' + version(),
    root() + 'Index/Css/Start.css?' + version(),
    ],
    () => {

        login.init({
            "route" : {
                "frontend" : {
                    "blocked" : "{{route.get(route.prefix() + '-user-login-blocked')}}",
                    "start" : "{{route.get(route.prefix() + '-navigation-main')}}"
                }
            }
        });
    });
});
