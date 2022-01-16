//{{R3M}}
import user from "/Module/User.js";
import create from "/Module/Create.js";
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
                        a = create('a', 'dropdown-item disabled')
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
                    button.html(a.html());
                    input.value = a.data('uuid');
                });
                ul.appendChild(li);
            }
        }
    });
}

menu.is_selected = (node, selected) => {
    if(selected){
        //select
        selected.removeClass('d-none');
    } else {
        //load
        if(node.data('has', 'url')){
            header('Authorization', 'Bearer ' + user.token());
            let url = node.data('url');
            if(stristr(url, '{node.domain}') !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                console.log('domain', domain);
                if(!domain){
                    return;
                }
                url = str_replace('{node.domain}', domain.value, url);
            }
            request(url, null, (url, response) => {
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
    menu.domain();
}

ready(() => {
    menu.init();
});
