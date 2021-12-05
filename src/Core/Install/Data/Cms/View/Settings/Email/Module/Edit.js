{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let edit = {};

edit.title = () => {
    console.log("{{$request}}");
}

edit.init = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
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
