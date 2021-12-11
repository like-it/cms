{R3M}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

let navigation = {};

navigation.init = () => {
    const navigation = getSectionByName("navigation");
    if(!navigation){
        request("{{route.get(route.prefix() + '-navigation-main')}}");
    }
    const section = getSectionByName("main-navigation");
    if(!section){
        console.warn('Cannot find section navigation...');
        return;
    }
    const route = "{{route.get(route.prefix() + '-home-main')}}";
    window.history.pushState(route, route, route);
    const active = section.select('.active');
    if(active){
        header('authorization', 'bearer ' + user.token());
        if(active.data('url')){
            request(active.data('url'), null, (url, response) => {
                if(active.data('frontend-url')){
                    request(active.data('frontend-url'), response);
                }
            });
        } else if(active.data('frontend-url')){
            request(active.data('frontend-url'));
        }
    }

};

ready(() => {
    require(
        [
            root() + 'Dialog/Css/Dialog.css?' + version(),
            root() + 'Dialog/Css/Dialog.Debug.css?' + version()
        ],
        () => {
            navigation.init();
        });
});
