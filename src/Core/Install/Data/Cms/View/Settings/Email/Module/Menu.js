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

menu.click = () => {
    const section = getSectionByName('main-content');
    console.log(section);
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    console.log(list);
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            const list = section.select('.nav-link');
            list.removeClass('active');
            node.addClass('active');
            const body = section.select('.card-body');
            console.log(body);
            if(body){
                body.addClass('d-none');
            }
            if(event.detail === 1){
                const selected = section.select(node.data('selected'));
                menu.is_selected(selected, node);
            } else {
                console.log('dblclick');
                menu.is_selected(false, node);
            }
        });
    }
}

menu.init = () => {
    //const route = "{{route.get(route.prefix() + '-settings-email-main')}}";
    //window.history.pushState(route, route, route);
    menu.click();
}

ready(() => {
    menu.init();
});
