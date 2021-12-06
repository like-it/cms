{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let add = {};

add.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body');
    body.addClass('d-none');
    const selected = section.select('.card-body-add');
    selected.removeClass('d-none');
}

add.form = (menu) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const form = section.select('form');
    if(form){
        form.on('submit', ( event ) => {
            event.preventDefault();
            header('authorization', 'Bearer ' + user.token());
            form.request(null, null, (url, response) => {
                if(
                    menu?.select &&
                    menu?.event
                ){
                    const menuItem = section.select(menu.select);
                    if(menuItem){
                        menuItem.dispatchEvent(menu.event);
                    }
                }
            });
        });
    }
}

add.init = () => {
    add.body();
    add.form({
        select : ".settings-email-settings",
        event : new MouseEvent("dblclick")
    });
};

ready(() => {
    add.init();
});
