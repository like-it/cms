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

settings.delete = () => {
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
                    const menuItem = section.select('.settings-email-settings');
                    if(menuItem){
                        menuItem.dispatchEvent(new MouseEvent("dblclick"));
                    }
                });
            }
        });
    }
}

settings.default = () => {
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
                    const menuItem = section.select('.settings-email-settings');
                    if(menuItem){
                        menuItem.dispatchEvent(new MouseEvent("dblclick"));
                    }
                });
            }
        });
    }
};

settings.init = () => {
    settings.default();
    settings.edit();
    settings.delete();
}

ready(() => {
    settings.init();

});
