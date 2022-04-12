//{{R3M}}
import user from "/Module/User.js";
import create from "/Module/Create.js";
import dialog from "/Module/Dialog.js";
import loader from "/Module/Loader.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { stristr, str_replace } from "/Module/String.js";
import { getSectionByName } from "/Module/Section.js";

let menu = {};

menu.domain = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const domain = section.select('.nav-item-domain');
    if(!domain){
        return;
    }
    const url = domain.data('url');
    header('Authorization', 'Bearer ' + user.token());
    request(url, null, (url, response) => {
        if(response?.nodeList){
            let uuid;
            const ul = domain.select('ul');
            const button = domain.select('button');
            const input = domain.select('input');
            for(uuid in response.nodeList){
                let node = response.nodeList[uuid];
                let li = create('li');
                let a;
                if(node?.is?.default){
                    a = create('a', 'dropdown-item active')
                    button.html(node.name);
                    input.value = uuid;
                    a.data('uuid', node.uuid);
                } else {
                    if(node?.is?.installed){
                        //a = create('a', 'dropdown-item disabled')
                        a = create('a', 'dropdown-item')
                        a.data('uuid', node.uuid);
                    } else {
                        a = create('a', 'dropdown-item')
                        a.data('uuid', node.uuid);
                    }
                }
                a.html(node.name);
                li.appendChild(a);
                a.on('click', (event) => {
                    if(event.target.hasClass('disabled')){
                        return;
                    }
                    const active  = ul.select('a.active');
                    if(active){
                        active.removeClass('active');
                    }
                    a.addClass('active');
                    button.html(a.html());
                    input.value = a.data('uuid');

                    const menu_active = section.select('.nav-link.active');
                    if(menu_active && menu_active.data('selected') === '.card-body-settings'){
                        menu_active.trigger('dblclick');
                    }
                    const menu_settings = section.select('.nav-link[data-selected=".card-body-settings"]');
                    if(menu_settings && !menu_settings.hasClass('active')){
                        menu_settings.data('reload', true);
                    }
                });
                ul.appendChild(li);
            }
        }
    });
}

menu.is_selected = (node, selected) => {
    if(
        selected &&
        !node.data('reload')
    ){
        //select
        selected.removeClass('d-none');
    } else {
        //load
        node.data('delete', 'reload');
        if(node.data('has', 'url')){
            header('Authorization', 'Bearer ' + user.token());
            let url = node.data('url');
            if(stristr(url, "{node.domain}") !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                if(!domain){
                    return;
                }
                url = str_replace("{node.domain}", domain.value, url);
            }
            if(node.data('page')){
                let page = node.data('page');
                page = parseInt(page);
                url += '?page=' + page;
            }
            if(node.data('filter-type')){
                url += '&filter[type]=' + node.data('filter-type');
            }
            if(node.data('limit')){
                url += '&limit=' + node.data('limit');
            }
            loader.start({
                className : "card-body h-100 card-body-loader",
                target: "card",
                section: "section[name='main-content']"
            });
            request(url, null, (url, response) => {
                if(response?.class === 'R3m\\Io\\Exception\\ErrorException'){
                    if(response.message === 'No domain found.'){
                        const section = getSectionByName('main-content');
                        if(!section){
                            return;
                        }
                        let dialog_create = dialog.create({
                            title : "{{__($module + '.' + $submodule + '.' + 'dialog.error.domain.title')}}",
                            message : "{{sentences(__($module + '.' + $submodule + '.' + 'dialog.error.domain.message'))}}",
                            buttons : [
                                {
                                    text : "{{__($module + '.' + $submodule + '.' + 'dialog.error.domain.button.ok')}}"
                                }
                            ],
                            section : section,
                            className : "dialog dialog-error dialog-error-domain"
                        });
                        let form = dialog_create.select('form');
                        if(form){
                            form.on('submit', (event) => {
                                event.preventDefault();
                                dialog_create.remove();
                            });
                        }
                    }
                }
                if(node.data('has', 'frontend-url')){
                    let url = node.data('frontend-url');
                    if(stristr(url, "{node.domain}") !== false){
                        const section = getSectionByName('main-content');
                        if(!section){
                            return;
                        }
                        const domain = section.select('input[name="node.domain"]');
                        if(!domain){
                            return;
                        }
                        url = str_replace("{node.domain}", domain.value, url);
                    }
                    if(node.data('filter-type')){
                        url += '?filter[type]=' + node.data('filter-type');
                    }
                    if(node.data('limit')){
                        url += '&limit=' + node.data('limit');
                    }
                    request(url, response, () => {
                        loader.delete({
                            className : "card-body-loader",
                            target: "card",
                            section: "section[name='main-content']"
                        });
                    });
                } else {
                    loader.delete({
                        className : "card-body-loader",
                        target: "card",
                        section: "section[name='main-content']"
                    });
                }
            });
        }
        else if(node.data('has', 'frontend-url')){
            let url = node.data('frontend-url');
            if(stristr(url, "{node.domain}") !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                if(!domain){
                    return;
                }
                url = str_replace("{node.domain}", domain.value, url);
            }
            if(node.data('filter-type')){
                url += '?filter[type]=' + node.data('filter-type');
            }
            if(node.data('limit')){
                url += '&limit=' + node.data('limit');
            }
            loader.start({
                className : "card-body h-100 card-body-loader",
                target: "card",
                section: "section[name='main-content']"
            });
            request(url, null, () => {
                loader.delete({
                    className : "card-body-loader",
                    target: "card",
                    section: "section[name='main-content']"
                });
            });
        }
    }
};

menu.onClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    if(is.nodeList(list)){
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
                const selected = section.select(node.data('selected'));
                menu.is_selected(node, selected);
            });
        }
    }
    else if(list){
        let node = list;
        node.on('click', (event) => {
            const list = section.select('.nav-link');
            list.removeClass('active');
            node.addClass('active');
            const body = section.select('.card-body');
            if(body){
                body.addClass('d-none');
            }
            const selected = section.select(node.data('selected'));
            menu.is_selected(node, selected);
        });
    }
}

menu.onDoubleClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
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
    else if(list){
        let node = list;
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
    menu.onDoubleClick();
    menu.domain();
}

ready(() => {
    require(
        [
            root() + 'Loader/Css/Loader.css?' + version(),
            root() + 'Dialog/Css/Dialog.Error.css?' + version(),
        ],
        () => {
            menu.init();
        });
});
