{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let menu = {};

menu.is_selected = (node, selected) => {
    if(selected){
        //select
        console.log('is selected');
        selected.removeClass('d-none');
    } else {
        //load
        if(node.data('has', 'url')){
            header('Authorization', 'Bearer ' + user.token());
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

menu.onClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            const list = section.select('.nav-link');
            list.removeClass('active');
            node.addClass('active');
            const body = section.select('.card-body');
            if(body){
                body.addClass('d-none');
            }
            if(event.detail === 1){
                const selected = section.select(node.data('selected'));
                menu.is_selected(node, selected);
            } else {
                menu.is_selected(node);
            }
        });
        node.on('dblclick', (event) => {
            const list = section.select('.nav-link');
            list.removeClass('active');
            node.addClass('active');
            const body = section.select('.card-body');
            if(body){
                body.addClass('d-none');
            }
            menu.is_selected(node);
        });
    }
}

menu.init = () => {
    //const route = "{{route.get(route.prefix() + '-settings-email-main')}}";
    //window.history.pushState(route, route, route);
    menu.onClick();
}

ready(() => {
    menu.init();
});
