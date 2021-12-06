{R3M}
import { getSectionByName } from "/Module/Section.js";

let main = {};

main.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body');
    body.addClass('d-none');
    const selected = section.select('.card-body-main');
    selected.removeClass('d-none');
}

main.init = () => {
    main.body();
};

ready(() => {
    main.init();
});
