//{{R3M}}
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";

let main = {};

main.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body');
    body.addClass('d-none');
    const selected = section.select('.card-' + "{{$command}}" + '-body');
    selected.removeClass('d-none');
}

main.init = () => {
    main.body();
};

ready(() => {
    require(
        [
            root() + 'Dialog/Css/Dialog.css?' + version(),
            root() + 'Dialog/Css/Dialog.Error.css?' + version(),
        ],
        () => {
            main.init();
        });
});
