{R3M}
import user from "/Module/User.js";
ready(() => {

    if(user.token()){

        const url = "{{server.url('core')}}User/Current/";
        header('authorization', 'Bearer ' + user.token());
        request(url, null, (url, response) => {

            if(!is.empty(response.user)){

                user.data(response.user);
            } else {

                if(user.refreshToken()){
                    //should get new token | refreshToken
                    const url = "{{server.url('core')}}User/Refresh/Token/";
                    header('authorization', 'Bearer ' + user.refreshToken());
                    request(url, null, (url, response) => {
                        if(!is.empty(response.user)){
                            if(response.user?.token){

                                user.token(response.user.token);
                            }

                            if(response.user?.refreshToken){

                                user.refreshToken(response.user.refreshToken);
                            }
                            const node = response.user;
                            delete node?.token;
                            delete node?.refreshToken;
                            user.data(node);
                        } else {

                            //redirect user login
                            redirect("{{route.get(route.prefix() + '-user-login')}}");
                        }

                    });
                }

            }

        });
    } else {

        if(user.refreshToken()){

            //validate refresh token and get user with new token & refreshToken
            const url = "{{server.url('core')}}User/Refresh/Token/";
            header('authorization', 'Bearer ' + user.refreshToken());
            request(url, null, (url, response) => {

                if(!is.empty(response.user)){
                    if(response.user?.token){

                        user.token(response.user.token);
                    }

                    if(response.user?.refreshToken){

                        user.refreshToken(response.user.refreshToken);
                    }
                    const node = response.user;
                    delete node?.token;
                    delete node?.refreshToken;
                    user.data(node);
                } else {

                    //redirect user login
                    redirect("{{route.get(route.prefix() + '-user-login')}}");
                }

            });
        } else {

            //redirect user login
            redirect("{{route.get(route.prefix() + '-user-login')}}");
        }

    }

});
