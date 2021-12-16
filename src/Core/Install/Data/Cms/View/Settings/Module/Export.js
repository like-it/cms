{R3M}
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";
import download from "/Module/Export/Download.js";
ready(() => {
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
    const link = section.select('#export');
    if(link){
        link.on('click', (event) => {
            if(user.token()){
                download.init({
                    url: "{{server.url('core')}}Export/",
                    filename: "funda-{{config('version')}}.zip",
                    token: user.token(),
                });
            } else {
                redirect("{{route.get(route.prefix() + '-user-Login')}}");
            }
        });
    }
});
