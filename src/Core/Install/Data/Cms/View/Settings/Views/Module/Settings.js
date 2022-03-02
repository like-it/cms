//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { contains, replace } from "/Module/String.js";
let settings = {};

settings.onDoubleClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.card-' + "{{$subcommand}}" + '-' + "{{$command}}" + ' tr');
    console.log(list);
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('dblclick', (event) => {
                if(node.data('has', 'url')){
                    header('Authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        console.log(response);
                        console.log(node.data('frontend-url'));
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                            console.log(frontendResponse);
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

settings.page = (type, section, data) => {
    console.log(data);
    if(
        is.array(data?.select)
    ){
        let index;
        for(index=0; index < data.select.length; index++){
            let item = data.select[index];
            if(
                item?.name
            ){
                const menuItem = section.select(item.name);
                if(menuItem) {
                    let page = "{{request('page')}}";
                    page = parseInt(page);
                    switch (type){
                        case 'current' :
                            page = data.page;
                            console.log('current', page);
                            menuItem.data('page', page);
                            break;
                        case 'next' :
                            page++;
                            menuItem.data('page', page);
                            break;
                        case 'previous' :
                            page--;
                            menuItem.data('page', page);
                            break;
                    }
                }
            }
        }
    } else {
        if(data?.select){
            const menuItem = section.select(data.select);
            if(menuItem){
                let page = "{{request('page')}}";
                page = parseInt(page);
                switch (type){
                    case 'current' :
                        page = data.page;
                        console.log('current', page);
                        menuItem.data('page', page);
                        break;
                    case 'next' :
                        page++;
                        menuItem.data('page', page);
                        break;
                    case 'previous' :
                        page--;
                        menuItem.data('page', page);
                        break;
                }
            }
        }
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
                if(contains(url, "{node.domain}") !== false){
                    const section = getSectionByName('main-content');
                    if(!section){
                        return;
                    }
                    const domain = section.select('input[name="node.domain"]');
                    console.log('domain', domain);
                    if(!domain){
                        return;
                    }
                    url = replace("{node.domain}", domain.value, url);
                }
                let data;
                if(node.data('request-method')){
                    data = {
                        "request-method" : node.data('request-method')
                    }
                }
                header('Authorization', 'Bearer ' + user.token());
                request(url, data, (url, response) => {
                    console.log(response);
                    if(node.data('move-to-next-page')){
                        settings.page('next', section, target);
                    }
                    else if(node.data('move-to-previous-page')){
                        settings.page('previous', section, target);
                    }
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
            if(contains(url, "{node.domain}") !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                console.log('domain', domain);
                if(!domain){
                    return;
                }
                url = replace("{node.domain}", domain.value, url);
            }
            let data;
            if(node.data('request-method')){
                data = {
                    "request-method" : node.data('request-method')
                }
            }
            header('Authorization', 'Bearer ' + user.token());
            request(url, data, (url, response) => {
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

settings.pagination = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const buttons = section.select('tfoot button');
    if(!buttons){
        return;
    }
    if(is.nodeList(buttons)){
        let index;
        for(index=0; index < buttons.length; index++){
            let button = buttons[index];
            button.on('click', () => {
                let url = button.data('url');
                if(contains(url, "{node.domain}") !== false){
                    const section = getSectionByName('main-content');
                    if(!section){
                        return;
                    }
                    const domain = section.select('input[name="node.domain"]');
                    console.log('domain', domain);
                    if(!domain){
                        return;
                    }
                    url = replace("{node.domain}", domain.value, url);
                }
                if(button.data('has', 'page')){
                    const section = getSectionByName('main-content');
                    if(!section){
                        return;
                    }
                    console.log('settings.page');
                    target.page = button.data('page');
                    target.page = parseInt(target.page);
                    settings.page('current', section, target);
                }
                header('Authorization', 'Bearer ' + user.token());
                request(url, null, (url, response) => {
                    request(button.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                    });
                });
            });
        }
    }
    else if(buttons){
        let button = buttons;
        button.on('click', () => {
            let url = button.data('url');
            if(contains(url, "{node.domain}") !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                console.log('domain', domain);
                if(!domain){
                    return;
                }
                url = replace("{node.domain}", domain.value, url);
            }
            if(button.data('has', 'page')){
                console.log('settings.page');
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                target.page = button.data('page');
                target.page = parseInt(target.page);
                settings.page('current', section, target);
            }
            header('Authorization', 'Bearer ' + user.token());
            request(url, null, (url, response) => {
                request(button.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                });
            });
        });
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

settings.search = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$command}}");
    if(!selected){
        return;
    }
    const form = selected.select('form[name="search"]');
    if(!form){
        return;
    }
    const input = form.select('input[type="search"]');
    if(!input){
        return;
    }
    form.on('submit', (event) => {
        event.preventDefault();
        let url = form.data('url');
        if(!url){
            return;
        }
        let split = url.split('?');
        if(split[1] && input.value.length > 0){
            url += '&q=' + input.value
        } else if(input.value.length > 0) {
            url += '?q=' + input.value
        }
        let frontend_url = form.data('frontend-url');
        if(!frontend_url){
            return;
        }
        if(contains(url, "{node.domain}") !== false){
            const section = getSectionByName('main-content');
            if(!section){
                return;
            }
            const domain = section.select('input[name="node.domain"]');
            if(!domain){
                return;
            }
            url = replace("{node.domain}", domain.value, url);
        }
        request(url,null, (response_url, response) => {
            request(frontend_url, response);
        });
    });

    input.on('change', (event) => {
        if(input?.value?.length >= 3){
            form.trigger('submit');
        }
        if(input?.value?.length === 0){
            form.trigger('submit');
        }
    });
    input.on('keydown', (event) => {
        if(input?.value?.length >= 3){
            form.trigger('submit');
        }
        if(input?.value?.length === 0){
            form.trigger('submit');
        }
    });
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
    settings.search();
    settings.pagination({
        select: ".{{$module}}-{{$submodule}}-{{$command}}"
    });
}

ready(() => {
    require(
    [
        root() + 'Dialog/Css/Dialog.css?' + version(),
        root() + 'Dialog/Css/Dialog.Delete.css?' + version(),
        root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + "{{$require.submodule}}" + '.css?' + version()
    ],
    () => {
        settings.init();
    });
});
