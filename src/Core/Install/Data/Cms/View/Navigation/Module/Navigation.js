{R3M}
import { getSectionByName} from "/Module/Section.js";

ready(() => {
    const section = getSectionByName("{{$controller.name}}");
    if(!section){
        console.warn('Cannot find section...');
        return;
    }
    const active = section.select('.active');
    if(active){
        active.request();
    }

});
