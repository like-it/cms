{R3M}
import user from "/Module/User.js";
import create from "/Module/Create.js";
import menu from "/Module/Menu.js";
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
    a.html("<span class='title'>{{$request.node.from_email}}</span><i class=\"fas fa-window-close\"></i>");
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

edit.form = (target) => {
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
                    menu.dispatch(target);
                }
            });
        });
    }
}

edit.onUpdate = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.uuid}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const input = form.select('input[name="node.from_email"]');
    if(!input){
        return;
    }
    input.on('change', (event) => {
        const link = section.select('.settings-email-edit-' + "{{$request.node.uuid}}");
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(input.value);
            }
        }
    });
    input.on('keyup', (event) => {
        const link = section.select('.settings-email-edit-' + "{{$request.node.uuid}}");
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(input.value);
            }
        }
    });
}

edit.focus = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.uuid}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const input = form.select('input[name="node.from_name"]');
    if(!input){
        return;
    }
    input.focus();
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
    edit.onUpdate();
    edit.focus();
};

ready(() => {
    edit.init();
});
