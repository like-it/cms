//{{R3M}}
import user from "/Module/User.js";
import create from "/Module/Create.js";
import menu from "/Module/Menu.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";
import { contains, replace } from "/Module/String.js";

let edit = {};

edit.title = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const is_link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
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
    const a = create('a', 'nav-link ' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
    a.data('frontend-url', "");
    a.data('url', "");
    a.html("<span class='title'>{{$request.node.name}}</span><i class=\"fas fa-window-close\"></i>");
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
            edit.body('show');
        } else {
            //reload from data url & frontend url
        }
    });
    const i = a.select('.fa-window-close');
    if(i){
        i.on('click', (event) => {
            event.stopPropagation();
            li.remove();
            edit.body('remove');
            const menuItem = section.select('.'+ "{{$module}}" + '-' + "{{$submodule}}" + '-' + 'settings');
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

edit.body = (action) => {
    if(is.empty(action)){
        action = 'show';
    }
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let body;
    let selected;
    switch(action){
        case 'show' :
            body = section.select('.card-body');
            body.addClass('d-none');
            selected = section.select('.card-body-' + "{{$request.node.key}}");
            selected.removeClass('d-none');
            break;
        case 'remove' :
            body = section.select('.card-body');
            body.addClass('d-none');
            selected = section.select('.card-body-' + "{{$request.node.key}}");
            selected.remove();
            break;
    }
}

edit.form = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(form){
        form.on('submit', ( event ) => {
            event.preventDefault();
            header('Authorization', 'Bearer ' + user.token());
            let data = form.data('serialize');
            let url = form.data('url');
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
            form.request(url, data, (url, response) => {
                if(response?.error){
                    data.push({
                        name: "error",
                        value: response.error
                    });
                    request(form.data('url-error'), data, ( urlError, responseError ) => {

                    });
                } else {
                    menu.dispatch(section, target);
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
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const input = form.select('input[name="node.name"]');
    if(!input){
        return;
    }
    input.on('change', (event) => {
        const link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(input.value);
            }
        }
    });
    input.on('keyup', (event) => {
        const link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
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
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const focus = "{{$request.focus}}";
    let input;
    if(focus){
        input = form.select('input[name="' + focus +'"]');
    } else {
        input = form.select('input[name="node.subdomain"]');
    }
    if(!input){
        return;
    }
    input.focus();
}

edit.content = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const ol = form.select('.node-content');
    if(!ol){
        return;
    }
    console.log(ol);
    console.log(ol.data('content'));
    ol.request(null, null, (url, response) => {
        console.log(response);
        if(response?.content){
            ol.html(response.content);
        }
    });
}

edit.init = () => {
    edit.body();
    edit.title();
    edit.content();
    edit.form({
        select : [
            {
                name : ".{{$module}}-{{$submodule}}-{{$command}}-{{$request.node.key}} .fa-window-close",
                event : new MouseEvent("click"),
                hidden : true
            },
            {
                name : ".{{$module}}-{{$submodule}}-settings",
                event : new MouseEvent("dblclick")
            }
        ]
    });
    edit.onUpdate();
    edit.focus();
};

ready(() => {
    require(
    [
        root() + 'Settings/Controllers/Css/Edit.css?' + version()
    ],
    () => {
        edit.init();
    });
});
