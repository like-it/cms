{R3M}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
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

update.init = () => {
    update.body();
};

ready(() => {
    update.init();
});
