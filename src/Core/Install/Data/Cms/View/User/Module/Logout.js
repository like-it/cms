{R3M}

import logout from "/User/Module/Logout.js";

ready(() => {
    logout.init({
        "route" : {
            "frontend" : {
                "blocked" : "{{route.get(route.prefix() + '-user-login-blocked')}}",
                "start" : "{{route.get(route.prefix() + '-navigation-main')}}"
            }
        }
    });
});
