{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";
ready(() => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.nav-link');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                list.removeClass('active');
                node.addClass('active');
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
        });
    }
    list = section.select('.settings-email-account-default');
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                request(node.data('url'), null, (url, response) => {
                    console.log(url);
                    console.log(response);
                    const settings = section.select('.settings-email-settings');
                    if(settings){
                        settings.trigger('click');
                    }
                });
            }

        });
    }
    list = section.select('.settings-email-settings-delete');
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                let data = {
                    request : {
                        method : node.data('request-method') ? node.data('request-method') : "DELETE"
                    }
                };
                request(node.data('url'), data, (url, response) => {
                    const settings = section.select('.settings-email-settings');
                    if(settings){
                        settings.trigger('click');
                    }
                });
            }

        });
    }
    list = section.select('.settings-email-settings-edit');
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                request(node.data('url'), null, (url, response) => {
                    console.log(response);
                    request(node.data('frontend-url', response, (frontendUrl, frontendResponse) => {
                        console.log(frontendResponse);
                    }));
                    /*
                    const settings = section.select('.settings-email-settings');
                    if(settings){
                        settings.trigger('click');
                    }
                     */
                });
            }

        });
    }


});
