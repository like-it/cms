//{{R3M}}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

let main = {};

main.navigation = () => {
    const section = getSectionByName("main-navigation");
    if(!section){
        console.warn('Cannot find section navigation...');
        return;
    }
    const route = "{{route.get(route.prefix() + '-home-main')}}";
    window.history.pushState(route, route, route);
    const active = section.select('.active');
    if(active){
        if(active.data('url')){
            header('Authorization', 'bearer ' + user.token());
            request(active.data('url'), null, (url, response) => {
                if(active.data('frontend-url')){
                    request(active.data('frontend-url'), response);
                }
            });
        }
        else if(active.data('frontend-url')){
            request(active.data('frontend-url'));
        }
    }
    const list = section.select('.nav-link');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                const list = section.select('.nav-link');
                list.removeClass('active');
                node.addClass('active');
                if(node.data('url')){
                    header('Authorization', 'bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        if(node.data('frontend-url')){
                            request(node.data('frontend-url'), response);
                        }
                    });
                }
                else if(node.data('frontend-url')){
                    request(node.data('frontend-url'));
                }
            });
        }
    } else {
        let node = list;
        node.on('click', (event) => {
            const list = section.select('.nav-link');
            list.removeClass('active');
            node.addClass('active');
            if(node.data('url')){
                header('Authorization', 'bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    if(node.data('frontend-url')){
                        request(node.data('frontend-url'), response);
                    }
                });
            }
            else if(node.data('frontend-url')){
                request(node.data('frontend-url'));
            }
        });
    }
}

ready(() => {
    const navigation = getSectionByName("navigation");
    if(!navigation){
        request("{{route.get(route.prefix() + '-navigation-main')}}");
    }
    main.navigation();
});
