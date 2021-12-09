{R3M}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";

let settings = {};

settings.doubleClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.card-body-settings tr');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('dblclick', (event) => {
                if(node.data('has', 'url')){
                    header('authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                        });
                    });
                }
            });
        }
    } else {
        let node = list;
        if(node){
            node.on('dblclick', (event) => {
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
}

settings.edit = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.settings-email-settings-edit');
    if(is.nodeList(list)){
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
    } else {
        let node = list;
        if(node){
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
}

settings.deleteDialog = (data) => {
    if(!data?.node){
        return;
    }
    if(!data?.section){
        const selection = data.node.data('select');
        if(selection){
            data.section = select(selection);
            if(!data.section){
                return;
            }
        } else {
            return;
        }
    }
    if(!data?.target){
        return;
    }
    if(!data?.className){
        data.className = 'dialog dialog-delete';
    }
    if(!data?.title){
        data.title = 'Delete';
    }
    if(!is.empty(data.node.data('title'))){
        data.title = data.node.data('title');
    }
    const section = data.section;
    const target = data.target;
    const node = data.node;
    const dialog = create('div', data.className);
    const header = create('div', 'head');
    const body = create('div', 'body');
    const footer = create('div', 'footer');
    header.html('<h1>' + data?.title + '</h1><span class="close"><i class="fas fa-window-close"></i></span>');
    if(!is.empty(node.data('name'))){
        body.html('<p>Are you sure you want to delete this item: ' + node.data('name') + '?<br></p>');
    } else {
        body.html('<p>Are you sure you want to delete this item?<br></p>');
    }
    footer.html('<div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-submit">Yes</button></div><div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-cancel">No</button></div>');
    dialog.appendChild(header);
    dialog.appendChild(body);
    dialog.appendChild(footer);
    section.appendChild(dialog);
    const close = header.select('.fa-window-close');
    if(close){
        close.on('click', (event) => {
            dialog.remove();
        });
    }
    const submit = footer.select('.button-submit');
    if(submit){
        submit.on('click', (event) => {
            if(node.data('has', 'url')){
                let data = {
                    request : {
                        method : node.data('request-method') ? node.data('request-method') : "DELETE"
                    }
                };
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), data, (url, response) => {
                    menu.dispatch(section, target);
                });
            }
            dialog.remove();
        });
    }
    const cancel = footer.select('.button-cancel');
    if(cancel){
        cancel.on('click', (event) => {
            dialog.remove();
        });
    }
}

settings.delete = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.settings-email-settings-delete');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                //make dialog delete with are you sure.
                settings.deleteDialog({
                    node: node,
                    section: section,
                    target: target,
                });
                /*
                if(node.data('has', 'url')){
                    let data = {
                        request : {
                            method : node.data('request-method') ? node.data('request-method') : "DELETE"
                        }
                    };
                    header('authorization', 'Bearer ' + user.token());
                    request(node.data('url'), data, (url, response) => {
                        menu.dispatch(section, target);
                    });
                }
                 */
            });
        }
    } else {
        let node = list;
        if(node){
            node.on('click', (event) => {
                //make dialog delete with are you sure.
                settings.deleteDialog({
                    node: node,
                    section: section,
                    target: target,
                });
                /*
                if(node.data('has', 'url')){
                    let data = {
                        request : {
                            method : node.data('request-method') ? node.data('request-method') : "DELETE"
                        }
                    };
                    header('authorization', 'Bearer ' + user.token());
                    request(node.data('url'), data, (url, response) => {
                        menu.dispatch(section, target);
                    });
                }
                 */
            });
        }
    }
}

settings.default = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.settings-email-account-default');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                if(node.data('has', 'url')){
                    header('authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        menu.dispatch(section, target);
                    });
                }
            });
        }
    } else {
        let node = list;
        if(node){
            node.on('click', (event) => {
                if(node.data('has', 'url')){
                    header('authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        menu.dispatch(section, target);
                    });
                }
            });
        }
    }
};

settings.init = () => {
    settings.doubleClick();
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
    require(
        [
            root() + 'Dialog/Css/Dialog.css?' + version(),
        ],
        () => {
            settings.init();
        });





});
