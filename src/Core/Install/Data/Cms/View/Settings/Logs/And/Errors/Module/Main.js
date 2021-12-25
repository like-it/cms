{R3M}
import { getSectionByName } from "/Module/Section.js";
import user from "/Module/User.js";

ready(() => {
    console.log('ready logs & errors...');
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const head = section.select('.card-header');
    if(!head){
        return;
    }
    const list = head.select('a');
    if(!list){
        return;
    }
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                list.removeClass('active');
                node.addClass('active');
                if(node.data('url')){
                    header('Authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, ( responseUrl, response) => {
                        console.log(response);
                        if(node.data('frontend-url')){
                            request(node.data('frontend-url', response));
                        }
                    });
                }
                else if(node.data('frontend-url')){
                    request(node.data('frontend-url'));
                }
            });
        }
    } else {
        let node = list;
        node.on('click', (event) => {
            list.removeClass('active');
            node.addClass('active');
            if(node.data('url')){
                console.log('has url');
                header('Authorization', 'Bearer ' + user.token());

            }
            else if(node.data('frontend-url')){
                request(node.data('frontend-url'));
            }
        });
    }
});
