{R3M}
import { getSectionByName } from "/Module/Section.js";

let main = {};

main.init = () => {
    main.header();
    main.select(0);
    main.content();
};

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


main.content = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const list = section.select('button.collapsed');
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.trigger('click');
    }
}

ready(() => {
    main.init();
});
