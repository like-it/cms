//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import { getSectionByName } from "/Module/Section.js";
import { uuid } from "/Module/Web.js";

let add = {};

add.title = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const attribute = uuid();
    const is_link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + attribute);
    if(is_link){
        const nav = section.select('.nav');
        const active = nav.select('.active');
        if(active){
            active.removeClass('active');
        }
        is_link.addClass('active');
        add.body();
        return;
    }
    const nav = section.select('.nav');
    const li = create('li', 'nav-item');
    const a = create('a', 'nav-link ' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + attribute);
    a.data('frontend-url', "");
    a.data('url', "");
    a.html("<span class='title'>Add file</span><i class=\"fas fa-window-close\"></i>");
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
            add.body('show');
        } else {
            //reload from data url & frontend url
        }
    });
    const i = a.select('.fa-window-close');
    if(i){
        i.on('click', (event) => {
            event.stopPropagation();
            li.remove();
            add.body('remove');
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


add.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const item = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}");
    if(item.data('is-hidden')){
        item.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-' + "{{$command}}" + '-body');
        selected.removeClass('d-none');
    }
}

add.onChange = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const form = section.select('form');
    if(!form){
        return;
    }
    let input = form.select('input[type="text"]');
    if(is.nodeList(input)){
        let index;
        for(index=0; index < input.length; index++){
            let node = input[index];
            node.on('change', (event) => {
                node.removeClass('alert-danger');
            });
        }
    } else if(input) {
        let node = input;
        node.on('change', (event) => {
            node.removeClass('alert-danger');
        });

    }
    input = form.select('input[type="password"]');
    if(is.nodeList(input)){
        let index;
        for(index=0; index < input.length; index++){
            let node = input[index];
            node.on('change', (event) => {
                node.removeClass('alert-danger');
            });
        }
    } else if(input){
        let node = input;
        node.on('change', (event) => {
            node.removeClass('alert-danger');
        });
    }
    input = form.select('select');
    if(is.nodeList(input)){
        let index;
        for(index=0; index < input.length; index++){
            let node = input[index];
            node.on('change', (event) => {
                node.removeClass('alert-danger');
            });
        }
    } else if(input) {
        let node = input;
        node.on('change', (event) => {
            node.removeClass('alert-danger');
        });
    }
}

add.form = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-' + "{{$command}}" + '-body');
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(form){
        form.on('submit', ( event ) => {
            event.preventDefault();
            header('Authorization', 'Bearer ' + user.token());
            let data = form.data('serialize');
            form.request(null, null, (url, response) => {
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

add.focus = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-' + "{{$command}}" + '-body');
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

add.init = () => {
    add.body();
    add.title();
    add.onChange();
    add.form({
        select : [
            {
                name : ".{{$module}}-{{$submodule}}-{{$command}}",
                event : new MouseEvent("dblclick"),
                hidden : true
            },
            {
                name : ".{{$module}}-{{$submodule}}-settings",
                event : new MouseEvent("dblclick")
            }
        ]
    });
    add.focus();
};

ready(() => {
    add.init();
});
