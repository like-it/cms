//{{R3M}}
import { getSectionByName } from "/Module/Section.js";

let information = {};

information.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body');
    body.addClass('d-none');
    const selected = section.select('.card-body-information');
    selected.removeClass('d-none');
}

information.init = () => {
    information.body();
};

ready(() => {
    information.init();
});
