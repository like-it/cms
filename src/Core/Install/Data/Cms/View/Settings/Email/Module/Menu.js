{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let menu = {};

menu.init = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    //const route = "{{route.get(route.prefix() + '-settings-email-main')}}";
    //window.history.pushState(route, route, route);
    const list = section.select('.nav-link');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                list.removeClass('active');
                node.addClass('active');
                const body = section.select('.card-body');
                body.addClass('display-none');
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    if(node.data('has', 'frontend-url')){
                        request(node.data('frontend-url'), response);
                    }
                });
            }
            else if(node.data('has', 'frontend-url')){
                list.removeClass('active');
                node.addClass('active');
                request(node.data('frontend-url'));
            }
        });
    }
}


ready(() => {
    menu.init();
    /*
    if(!is.empty(list)){
        list[0].trigger('click');
    }
     */
});
