{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let settings = {};

settings.edit = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.settings-email-settings-edit');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                    });
                });
            }
        });
    }
}

settings.delete = (menu) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.settings-email-settings-delete');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            //make dialog delete with are you sure.
            if(node.data('has', 'url')){
                let data = {
                    request : {
                        method : node.data('request-method') ? node.data('request-method') : "DELETE"
                    }
                };
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), data, (url, response) => {
                    if(
                        menu?.select &&
                        menu?.event
                    ){
                        const menuItem = section.select(menu.select);
                        if(menuItem){
                            menuItem.dispatchEvent(menu.event);
                        }
                    }
                });
            }
        });
    }
}

settings.default = (menu) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.settings-email-account-default');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    console.log(menu);
                    if(
                        menu?.select &&
                        menu?.event
                    ){
                        const menuItem = section.select(menu.select);
                        if(menuItem){
                            menuItem.dispatchEvent(menu.event);
                        }
                    }
                });
            }
        });
    }
};

settings.init = () => {
    settings.default({
        select : ".settings-email-settings",
        event : new MouseEvent("dblclick")
    });
    settings.edit();
    settings.delete({
        select: ".settings-email-settings",
        event: new MouseEvent("dblclick")
    });
}

ready(() => {
    settings.init();

});
