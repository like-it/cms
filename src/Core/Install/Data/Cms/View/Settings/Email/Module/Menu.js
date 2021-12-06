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
            if(event.detail === 1 && node.hasClass('settings-email-add')){
                const list = section.select('.nav-link');
                list.removeClass('active');
                node.addClass('active');
                const body = section.select('.card-body');
                body.addClass('display-none');
                const selected = section.select('.card-body-add');
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
            } else {
                if(node.data('has', 'url')){
                    const list = section.select('.nav-link');
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
                    const list = section.select('.nav-link');
                    list.removeClass('active');
                    node.addClass('active');
                    const body = section.select('.card-body');
                    body.addClass('display-none');
                    request(node.data('frontend-url'));
                }
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
