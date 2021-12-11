{R3M}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import { getSectionByName } from "/Module/Section.js";

let add = {};

add.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const menu = section.select('.settings-email-add');
    if(menu.data('is-hidden')){
        menu.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-body-add');
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
    } else {
        let node = input;
        if(node){
            node.on('change', (event) => {
                node.removeClass('alert-danger');
            });
        }
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
    } else {
        let node = input;
        if(node){
            node.on('change', (event) => {
                node.removeClass('alert-danger');
            });
        }
    }
}

add.form = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-add');
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
                    request(form.data('url-error'), data, ( urlError, responseError ) => {

                    });
                    console.log(response.error);
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
    const selected = section.select('.card-body-add');
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

add.init = () => {
    add.body();
    add.onChange();
    add.form({
        select : [
            {
                name : ".settings-email-add",
                event : new MouseEvent("dblclick"),
                hidden : true
            },
            {
                name : ".settings-email-settings",
                event : new MouseEvent("dblclick")
            }
        ]
    });
    add.focus();
};

ready(() => {
    add.init();
});
