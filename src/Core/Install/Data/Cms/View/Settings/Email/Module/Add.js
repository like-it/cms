{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let add = {};

add.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const menu = section.select('.settings-email-add');
    const body = section.select('.card-body');
    body.addClass('d-none');
    if(menu.data('is-hidden')){
        menu.data('delete', 'is-hidden');
    } else {
        const selected = section.select('.card-body-add');
        selected.removeClass('d-none');
    }
}

add.change = () => {
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
    } else {
        let node = input;
        node.on('change', (event) => {
            node.removeClass('alert-danger');
        });
    }
}

add.form = (menu) => {
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
                    console.log(menu?.select);
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
    add.change();
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
