//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import { getSectionByName } from "/Module/Section.js";

let view = {};

view.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const item = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}");
    if(item.data('is-hidden')){
        item.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-' + "{{$subcommand}}" + '-' + "{{$command}}" + '-' + "{{$request.node.uuid}}");
        selected.removeClass('d-none');
    }
}


view.init = () => {
    view.body();
};

ready(() => {
    view.init();
});
