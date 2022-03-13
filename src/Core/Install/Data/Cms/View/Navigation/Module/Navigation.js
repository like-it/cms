//{{R3M}}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";

let navigation = {};

navigation.init = () => {
    const name = "{{$controller.name}}";
    const section = getSectionByName(name);
    if (!section) {
        console.warn('Cannot find section...');
        return;
    }
    const active = section.select('.active');
    if (active) {
        active.request();
    }
    const list = section.select('.nav-link');
    let index;
    for (index = 0; index < list.length; index++) {
        let node = list[index];
        node.on('click', (event) => {
            list.removeClass('active');
            node.addClass('active');
            header('Authorization', 'bearer ' + user.token());
            if(node.data('url')){
                request(node.data('url'), null, (url, response) => {
                    if(node.data('frontend-url')){
                        request(node.data('frontend-url'), response);
                    }

                });
            }
            else if(node.data('frontend-url')){
                request(node.data('frontend-url'));
            }

        });
    }
};

ready(() => {
    require(
        [
            root() + 'Dialog/Css/Dialog.css?' + version(),
            root() + 'Dialog/Css/Dialog.Debug.css?' + version()
        ],
        () => {
            navigation.init();
        });
});
