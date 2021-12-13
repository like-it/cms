{R3M}
import create from "/Module/Create.js";
import user from "/Module/User.js";
import url from "/Module/Url.js";
import { getSectionByName } from "/Module/Section.js";

let update = {};

update.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const menu = section.select('.system-update');
    if(menu.data('is-hidden')){
        menu.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-body-update');
        selected.removeClass('d-none');
    }
}

update.button = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body-update');
    if(!body){
        return;
    }
    const list = body.select('.btn');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    if(response?.node?.output){
                        update.cms(response);
                    }
                    console.log(url);
                    console.log(response);
                });
            });
        }
    } else {
        let node = list;
        if(node){
            node.on('click', (event) => {
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    if(response?.node?.output){
                        update.cms(response.node);
                    }
                    console.log(url);
                    console.log(response);
                });
            });
        }
    }
}

update.cms = (node) => {
    const read = "{{server.url('core')}}FileSystem/Read/?url=" + url.encode(node.output);

    request(read, null, (url, response) => {
        if(response.class === 'R3m\\Io\\Exception\\FileNotExistException'){
            setTimeout(() => {
                update.cms(node);
            }, 5000);
        } else {
            const section = getSectionByName('main-content');
            if(!section){
                return;
            }
            const body = section.select('.card-body-update');
            if(!body){
                return;
            }
            const system = body.select('.system-console');
            if(!system){
                return;
            }
            const pre = create('pre');
            pre.html(response);
            system.removeClass('d-none');
            system.appendChild(pre);
        }
    });
}


update.init = () => {
    update.body();
    update.button();
};

ready(() => {
    update.init();
});
