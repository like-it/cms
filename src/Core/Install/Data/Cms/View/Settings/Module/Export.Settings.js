{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";
ready(() => {

    const section = getSectionByName('main-content');
    if(!section){

        return;
    }

    const form = section.select('form');
    form.on('submit', (event) => {

        event.preventDefault();
        header('authorization', 'Bearer ' + user.token());
        form.request(form.data('url'), null, (url, response) => {

            if(form.data('has', 'frontend-url')){

                request(form.data('frontend-url'), response);
            }

        });
    });
});
