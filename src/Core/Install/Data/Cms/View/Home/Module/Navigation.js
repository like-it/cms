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
        request(active.data('url'), null, (url, response) => {
            if(active.data('frontend-url')){
                response?.method !== null ? response.method : active.data('method');
                response?.target !== null ? response.target : active.data('target');
                request(active.data('frontend-url'), response);
            }
        });
    }

});
