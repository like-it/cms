{R3M}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

ready(() => {
    const section = getSectionByName("main-navigation");
    if(!section){
        console.warn('Cannot find section navigation...');
        return;
    }
    const active = section.select('.active');
    if(active){
        header('authorization', 'bearer ' + user.token());
        active.request();
    }

});
