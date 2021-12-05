{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";
ready(() => {
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
                const settings = section.select('.settings-email-settings');
                if(settings){
                    settings.trigger('click');
                }
            });
        });
    }
});
