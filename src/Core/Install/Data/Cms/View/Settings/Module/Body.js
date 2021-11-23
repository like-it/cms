{R3M}
import { getSectionByName } from "/Module/Section.js";

ready(() => {

    const section = getSectionByName('main-content');
    if(!section){

        return;
    }
    const list = section.select('button');
    let index;
    for(index=0; index < list.length; index++){

        let node = list[index];
        node.trigger('click');
    }

});
