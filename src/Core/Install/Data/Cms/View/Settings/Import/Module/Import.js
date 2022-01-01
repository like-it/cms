{R3M}
import { root } from "/Module/Web.js";
import { version } from "/Module/Priya.js";
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";
import upload from "/Module/Import/Upload.js";

let module = {};

module.init = () => {
    module.upload();
    module.navigation();
}

module.navigation = () => {
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
}

module.upload = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    require(
        [
            root() + 'Dropzone/5.9.2/Min/dropzone.min.js?' + version(),
            root() + 'Dropzone/5.9.2/Min/dropzone.min.css?' + version()
        ],
        function(){
            if(user.token()){
                upload.init({
                    url : "{{server.url('core')}}Import/",
                    token: user.token(),
                    upload_max_filesize: "1024 M",
                    target : "section[name=\"main-content\"] .card-body"
                });
            } else {
                redirect("{{server.url('cms')}}User/Login/")
            }
        }
    );
}

ready(() => {
    module.init();
});
