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
    const nav = section.select('.nav');
    const li = create('li', 'nav-item');
    const a = create('a', 'nav-link settings-email-edit-' + "{{$request.node.uuid}}");
    a.data('frontend-url', "");
    a.data('url', "");
    a.html("{{$request.node.from.name}}");
    li.append(a);
    nav.append(li);
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
