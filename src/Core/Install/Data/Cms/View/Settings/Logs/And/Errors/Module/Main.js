{R3M}
import { getSectionByName } from "/Module/Section.js";
ready(() => {
    console.log('ready logs & errors...');
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const header = section.select('.card-header');
    if(!header){
        return;
    }
    const list = header.select('a');
    if(!list){
        return;
    }
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('click', (event) => {
                if(node.data('url')){
                    console.log('has url');
                }
                else if(node.data('frontend-url')){
                    request(node.data('frontend-url'));
                }
            });
        }
    } else {
        let node = list;
        node.on('click', (event) => {
            if(node.data('url')){
                console.log('has url');
            }
            else if(node.data('frontend-url')){
                request(node.data('frontend-url'));
            }
        });
    }
});
