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

add.form = () => {
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
                const menuItem = section.select('.settings-email-settings');
                if(menuItem){
                    let clickEvent  = document.createEvent ('MouseEvents');
                    clickEvent.initEvent ('dblclick', true, true);
                    menuItem.dispatchEvent (clickEvent);
                }
            });
        });
    }
}

add.init = () => {
    add.body();
    add.form();
};

ready(() => {
    add.init();
});
