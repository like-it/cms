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
                } else {
                    if(node?.is?.installed){
                        a = create('a', 'dropdown-item disabled')
                    } else {
                        a = create('a', 'dropdown-item')
                    }
                }
                a.html(node.name);
                a.data('uuid', node.uuid);
                li.appendChild(a);
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
