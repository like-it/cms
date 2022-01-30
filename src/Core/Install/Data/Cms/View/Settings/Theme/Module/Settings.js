//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";

let settings = {};

settings.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const item = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' +  "{{$command}}");
    if(item.data('is-hidden')){
        item.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-body-' + "{{$command}}");
        selected.removeClass('d-none');
    }
}

settings.init = () => {
    settings.body();
}

ready(() => {
    require(
    [
        root() + 'Dialog/Css/Dialog.css?' + version(),
        root() + 'Dialog/Css/Dialog.Delete.css?' + version()
    ],
    () => {
        settings.init();
    });
});
