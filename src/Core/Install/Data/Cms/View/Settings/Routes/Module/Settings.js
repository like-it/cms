//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { stristr, str_replace } from "/Module/String.js";
let settings = {};

settings.onDoubleClick = () => {
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
                    header('Authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                        });
                    });
                }
            });
        }
    } else if(list) {
        let node = list;
        node.on('dblclick', (event) => {
            if(node.data('has', 'url')){
                header('Authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                    });
                });
            }
        });

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
    const head = create('div', 'head');
    const body = create('div', 'body');
    const footer = create('div', 'footer');
    head.html('<h1>' + data?.title + '</h1><span class="close"><i class="fas fa-window-close"></i></span>');
    if(!is.empty(node.data('name'))){
        body.html('<p>' + "{{__($__.module + '.' + $__.submodule + '.module.' + $__.command + '.delete')}}" + ': ' + node.data('name') + '?<br></p>');
    } else {
        body.html('<p>' + "{{__($__.module + '.' + $__.submodule + '.module.' + $__.command + '.delete')}}" + '?<br></p>');
    }
    footer.html('<div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-submit">Yes</button></div><div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-cancel">No</button></div>');
    dialog.appendChild(head);
    dialog.appendChild(body);
    dialog.appendChild(footer);
    section.appendChild(dialog);
    const close = head.select('.fa-window-close');
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
        submit.focus();
    }
    const cancel = footer.select('.button-cancel');
    if(cancel){
        cancel.on('click', (event) => {
            dialog.remove();
        });
    }
}

settings.actions = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const actions = section.select('.actions');
    if(!actions){
        return;
    }
    const i = actions.select('i');
    if(is.nodeList(i)){
        let index;
        for(index=0; index < i.length; index++){
            let node = i[index];
            node.on('click', (event) => {
                let url = node.data('url');
                if(stristr(url, "{node.domain}") !== false){
                    const section = getSectionByName('main-content');
                    if(!section){
                        return;
                    }
                    const domain = section.select('input[name="node.domain"]');
                    console.log('domain', domain);
                    if(!domain){
                        return;
                    }
                    url = str_replace("{node.domain}", domain.value, url);
                }
                header('Authorization', 'Bearer ' + user.token());
                request(url, null, (url, response) => {
                    console.log(response);
                    menu.dispatch(section, target);
                    /*
                    request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                    });
                     */
                });
            });
        }
    } else if(i){
        let node = i;
        node.on('click', (event) => {
            let url = node.data('url');
            if(stristr(url, "{node.domain}") !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                console.log('domain', domain);
                if(!domain){
                    return;
                }
                url = str_replace("{node.domain}", domain.value, url);
            }
            header('Authorization', 'Bearer ' + user.token());
            request(url, null, (url, response) => {
                console.log(response);
                menu.dispatch(section, target);
                /*
                request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                });
                 */
            });
        });
    }
}


settings.options = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.dropdown-item');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            if(node.hasClass('item-delete')){
                node.on('click', (event) => {
                    //make dialog delete with are you sure.
                    settings.deleteDialog({
                        node: node,
                        section: section,
                        target: target,
                    });
                });
            }
            else {
                node.on('click', (event) => {
                    if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                        header('Authorization', 'Bearer ' + user.token());
                        request(node.data('url'), null, (url, response) => {
                            request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                            });
                        });
                    }
                    else if(node.data('has', 'frontend-url')){
                        request(node.data('frontend-url'), null, (url, response) => {

                        });
                    }
                });
            }

        }
    }
    else if(list){
        let node = list;
    }
}

settings.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const item = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' +  "{{$command}}");
    if(item.data('is-hidden')){
        item.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-body-' + "{{$command}}");
        selected.removeClass('d-none');
    }
}

settings.init = () => {
    settings.body();
    settings.onDoubleClick();
    settings.actions({
        select: ".{{$module}}-{{$submodule}}-{{$command}}",
        event: new MouseEvent("dblclick")
    });
    settings.options({
        select: ".{{$module}}-{{$submodule}}-{{$command}}",
        event: new MouseEvent("dblclick")
    });
}

ready(() => {
    require(
    [
        root() + 'Dialog/Css/Dialog.css?' + version(),
        root() + 'Dialog/Css/Dialog.Delete.css?' + version(),
        root() + 'Settings/Routes/Css/Routes.css?' + version()
    ],
    () => {
        settings.init();
    });
});
