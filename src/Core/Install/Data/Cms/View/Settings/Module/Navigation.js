{R3M}
import user from "/Module/User.js";
import { getSectionByName} from "/Module/Section.js";

ready(() => {

    const navigation = getSectionByName("navigation");
    if(!navigation){

        request("{{route.get(route.prefix() + '-navigation-main')}}");
    }

    const section = getSectionByName("main-navigation");
    if(!section){

        console.warn('Cannot find section navigation...');
        return;
    }

    const route = "{{route.get(route.prefix() + '-settings-main')}}";
    window.history.pushState(route, route, route);
    const list = section.select('a');
    console.log(list);
    let index;
    for(index=0; index < list.length; index++){
        let node = list[index];
        node.on('click', (event) => {

            list.removeClass('active');
            node.addClass('active');
            console.log(node);
            console.log(node.data('has', 'url'));
            if(node.data('has', 'url')){
                header('authorization', 'bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {

                    if(node.data('frontend-url')){

                        request(node.data('frontend-url'), response);
                    }

                });
            }
            else if(node.data('frontend-url')){
                console.log('clicked');
                request(node.data('frontend-url'));
            }

        });
    }
    const active = section.select('.active');
    if(active){

        active.trigger('click');
    }
    /*
    const settings = select("[data-url=\"" + route + "\"]");
    if(settings){

        console.log(settings);
        /*
        header('authorization', 'bearer ' + user.token());
        request(settings.data('url'), null, (url, response) => {
            if(settings.data('frontend-url')){
                request(settings.data('frontend-url'), response);
            }

        });

    }
     */

});
