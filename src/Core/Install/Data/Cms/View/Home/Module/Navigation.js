{R3M}
import { getSectionByName} from "/Module/Section.js";

ready(() => {
    const section = getSectionByName("{{$section.name}}-navigation");
    if(!section){
        console.warn('Cannot find section navigation...');
        return;
    }
    const active = section.select('.active');
    if(active){
        active.request();
    }

});
