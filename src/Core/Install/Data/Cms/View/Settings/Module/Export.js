{R3M}
import user from "/Module/User.js";
import download from "/Module/Export/Download.js";
ready(() => {

    if(user.token()){

        download.init({

            url: "{{server.url('core')}}Export/",
            filename: "funda-{{config('version')}}.zip",
            token: user.token(),
        });
    } else {

        redirect("{{route.get(route.prefix() + 'user-Login')}}");
    }

});
