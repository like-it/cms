{R3M}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

ready(() => {
    const section = getSectionByName("{{$controller.name}}");
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
            header('authorization', 'bearer ' + user.token());
            request(node.data('url'), null, (url, response) => {
                if(node.data('frontend-url')){
                    request(node.data('frontend-url'), response);
                }

            });
        });
    }

});
