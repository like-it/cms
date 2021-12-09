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
    const is_link = section.select('.settings-email-edit-' + "{{$request.node.uuid}}");
    if(is_link){
        const nav = section.select('.nav');
        const active = nav.select('.active');
        if(active){
            active.removeClass('active');
        }
        is_link.addClass('active');
        edit.body();
        return;
    }
    const nav = section.select('.nav');
    const li = create('li', 'nav-item');
    const a = create('a', 'nav-link settings-email-edit-' + "{{$request.node.uuid}}");
    a.data('frontend-url', "");
    a.data('url', "");
    a.html("{{$request.node.from_name}} <i class=\"fas fa-window-close\"></i>");
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
    body.addClass('d-none');
    const selected = section.select('.card-body-' + "{{$request.node.uuid}}");
    selected.removeClass('d-none');
}

edit.form = (menu) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.uuid}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(form){
        form.on('submit', ( event ) => {
            event.preventDefault();
            header('authorization', 'Bearer ' + user.token());
            let data = form.data('serialize');
            form.request(null, null, (url, response) => {
                if(response?.error){
                    data.push({
                        name: "error",
                        value: response.error
                    });
                    console.log(form.data('url-error'));
                    request(form.data('url-error'), data, ( urlError, responseError ) => {

                    });
                    console.log(response.error);
                } else {
                    if(
                        is.array(menu?.select)
                    ){
                        let index;
                        for(index=0; index < menu.select.length; index++){
                            let item = menu.select[index];
                            if(
                                item?.name &&
                                item?.event
                            ){
                                const menuItem = section.select(item.name);
                                if(menuItem){
                                    if(
                                        item?.hidden
                                    ){
                                        menuItem.data('is-hidden', item?.hidden);
                                    }
                                    menuItem.dispatchEvent(item.event);
                                }
                            }
                        }
                    } else {
                        if(
                            menu?.select &&
                            menu?.event
                        ){
                            const menuItem = section.select(menu.select);
                            if(menuItem){
                                if(
                                    menu?.hidden
                                ){
                                    menuItem.data('is-hidden', menu?.hidden);
                                }
                                menuItem.dispatchEvent(menu.event);
                            }
                        }
                    }
                }
            });
        });
    }
}

edit.init = () => {
    edit.body();
    edit.title();
    edit.form({
        select : [
            {
                name : ".settings-email-edit-{{$request.node.uuid}} .fa-window-close",
                event : new MouseEvent("click"),
                hidden : true
            },
            {
                name : ".settings-email-settings",
                event : new MouseEvent("dblclick")
            }
        ]
    });
};

ready(() => {
    edit.init();
});
