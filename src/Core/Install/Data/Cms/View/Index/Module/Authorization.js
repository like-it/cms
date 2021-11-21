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

                    console.log('refreshToken: ' + user.refreshToken());
                    const url = "{{server.url('core')}}User/Refresh/Token/";
                    header('authorization', 'Bearer ' + user.refreshToken());
                    request(url, null, (url, response) => {

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
                }
            }
        });
    } else {

        if(user.refreshToken()){

            console.log('refreshToken: ' + user.refreshToken());
            const url = "{{server.url('core')}}User/Refresh/Token/";
            header('authorization', 'Bearer ' + user.refreshToken());
            request(url, null, (url, response) => {

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
