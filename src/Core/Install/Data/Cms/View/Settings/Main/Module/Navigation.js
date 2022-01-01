{R3M}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

let navigation = {};

navigation.init = () => {
    const route = "{{route.get(route.prefix() + '-settings-main-main')}}";
    window.history.pushState(route, route, route);
    navigation.main();
    navigation.section();
    navigation.active();
};

navigation.active = () => {
    const section = getSectionByName("main-navigation");
    if(!section){
        console.warn('Cannot find section navigation...');
        return;
    }
    const active = section.select('.active');
    if(active){
        active.trigger('click');
    }
}

navigation.main = () => {
    const nav = getSectionByName("navigation");
    if(!nav){
        request("{{route.get(route.prefix() + '-navigation-main')}}");
    }
};

navigation.section = () => {
    const section = getSectionByName("main-navigation");
    if(!section){
        console.warn('Cannot find section navigation...');
        return;
    }
    const list = section.select('a');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                list.removeClass('active');
                node.addClass('active');
                if(node.data('has', 'url')){
                    header('Authorization', 'bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        if(node.data('frontend-url')){
                            request(node.data('frontend-url'), response);
                        }
                    });
                }
                else if(node.data('has', 'frontend-url')){
                    request(node.data('frontend-url'));
                }
            });
        }
    } else if(list) {
        let node = list;
        node.on('click', (event) => {
            node.addClass('active');
            if(node.data('has', 'url')){
                header('Authorization', 'bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    if(node.data('frontend-url')){
                        request(node.data('frontend-url'), response);
                    }
                });
            }
            else if(node.data('has', 'frontend-url')){
                request(node.data('frontend-url'));
            }
        });
    }
};

ready(() => {
    navigation.init();
});
