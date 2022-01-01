{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";

let settings = {};

settings.init = () => {
    settings.header();
    settings.select(1);
    settings.form();
};

settings.select = (index) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    if(!is.empty(list[index])){
        let node = list[index];
        list.removeClass('active');
        node.addClass('active');
    }
}

settings.header = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {
            if(node.data('has', 'url')){
                list.removeClass('active');
                node.addClass('active');
                header('Authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    if(node.data('has', 'frontend-url')){
                        request(node.data('frontend-url'), response);
                    }
                });
            }
            else if(node.data('has', 'frontend-url')){
                request(node.data('frontend-url'));
            }
        });
    }
};

settings.form = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const form = section.select('form');
    form.on('submit', (event) => {
        event.preventDefault();
        header('Authorization', 'Bearer ' + user.token());
        form.request(form.data('url'), null, (url, response) => {
            if(form.data('has', 'frontend-url')){
                request(form.data('frontend-url'), response);
            }
        });
    });
};


ready(() => {
    settings.init();
});
