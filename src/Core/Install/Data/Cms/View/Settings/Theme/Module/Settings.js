//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";

let settings = {};

settings.onDoubleClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.card-body-settings tr');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('dblclick', (event) => {
                if(node.data('has', 'url')){
                    header('Authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                        });
                    });
                }
            });
        }
    } else if(list) {
        let node = list;
        node.on('dblclick', (event) => {
            if(node.data('has', 'url')){
                header('Authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                    });
                });
            }
        });

    }
}

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
