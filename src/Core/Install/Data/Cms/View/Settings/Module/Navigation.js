{R3M}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

ready(() => {
    
    const navigation = getSectionByName("navigation");
    if(!navigation){

        request("{{route.get(route.prefix() + '-navigation-main')}}");
    }

    const section = getSectionByName("main-navigation");
    if(!section){

        console.warn('Cannot find section navigation...');
        return;
    }

    const route = "{{route.get(route.prefix() + '-settings-main')}}";
    window.history.pushState(route, route, route);
    const settings = select("[data-url=\"" + route + "\"]");
    if(settings){
        header('authorization', 'bearer ' + user.token());
        request(settings.data('url'), null, (url, response) => {
            if(settings.data('frontend-url')){
                request(settings.data('frontend-url'), response);
            }

        });
    }

});
