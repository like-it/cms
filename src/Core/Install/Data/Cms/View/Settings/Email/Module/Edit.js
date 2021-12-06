{R3M}
import user from "/Module/User.js";
import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";

let edit = {};

edit.title = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const nav = section.select('.nav');
    const li = create('li', 'nav-item');
    const a = create('a', 'nav-link settings-email-edit-' + "{{$request.node.uuid}}");
    a.data('frontend-url', "");
    a.data('url', "");
    a.html("{{$request.node.from.name}} <i class=\"fas fa-window-close\"></i>");
    li.append(a);
    nav.append(li);
    a.on('click', (event) => {
        if(event.detail === 1){
            const ul = li.parentNode;
            const active = ul.select('.active');
            if(active){
                active.removeClass('active');
            }
            a.addClass('active');
            edit.body();
        } else {
            //reload from data url & frontend url
        }
        console.log(event.detail);



    });
    const i = a.select('.fa-window-close');
    if(i){
        i.on('click', (event) => {
            event.stopPropagation();
            li.remove();
            const menuItem = section.select('.settings-email-settings');
            if(menuItem){
                menuItem.trigger('click');
            }
        });
    }
    const ul = li.parentNode;
    const active = ul.select('.active');
    if(active){
        active.removeClass('active');
    }
    a.addClass('active');
}

edit.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body');
    body.addClass('display-none');
    const selected = section.select('.card-body-' + "{{$request.node.uuid}}");
    selected.removeClass('display-none');
}

edit.init = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    edit.body();
    edit.title();
    const form = section.select('form');
    if(form){
        form.on('submit', ( event ) => {
            event.preventDefault();
            header('authorization', 'Bearer ' + user.token());
            form.request(null, null, (url, response) => {
                const menuItem = section.select('.settings-email-settings');
                if(menuItem){
                    menuItem.trigger('click');
                }
            });
        });
    }
};

ready(() => {
    edit.init();
});
