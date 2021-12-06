{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let menu = {};

menu.is_selected = (selected, node) => {
    if(selected){
        //select
        selected.removeClass('display-none');
    } else {
        //load
        if(node.data('has', 'url')){
            header('authorization', 'Bearer ' + user.token());
            request(node.data('url'), null, (url, response) => {
                if(node.data('has', 'frontend-url')){
                    request(node.data('frontend-url'), response);
                }
            });
        }
        else if(node.data('has', 'frontend-url')){
            request(node.data('frontend-url'));
        }
    }
};

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
            const list = section.select('.nav-link');
            list.removeClass('active');
            node.addClass('active');
            const body = section.select('.card-body');
            body.addClass('display-none');
            if(event.detail === 1){
                const selected = section.select(node.data('selected'));
                menu.is_selected(selected, node);
            } else {
                menu.is_selected(false, node);
            }
        });
    }
}

ready(() => {
    menu.init();
});
