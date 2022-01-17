//{{R3M}}
import { root } from "/Module/Web.js";
import { version } from "/Module/Priya.js";
import user from "/Module/User.js";
import { getSectionByName } from "/Module/Section.js";
import upload from "/Settings/Import/Module/Upload.js";

let main = {};

main.init = () => {
    main.header();
    main.select(0);
    main.upload();

}

main.select = (index) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    if(is.nodeList(list)){
        if(!is.empty(list[index])){
            let node = list[index];
            list.removeClass('active');
            node.addClass('active');
        }
    } else {
        let node = list;
        if(node){
            node.addClass('active');
        }
    }
}

main.header = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('.nav-link');
    let index;
    if(is.nodeList(list)){
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
    } else if (list){
        let node = list;
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

main.upload = () => {
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
    main.init();
});
