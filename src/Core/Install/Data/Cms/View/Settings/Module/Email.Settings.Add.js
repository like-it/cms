{R3M}
//import user from "/Module/User.js";
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
            form.request(null, null, (url, response) => {
                console.log(url);
                console.log(response);
            });
        });
    }
});
