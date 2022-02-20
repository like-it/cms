//{{R3M}}
import create from "/Module/Create.js";
import user from "/Module/User.js";
import menu from "/Module/Menu.js";

import { getSectionByName } from "/Module/Section.js";

let view = {};

view.progress = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-view-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const progress = selected.select('.progress');
    if(!progress){
        return;
    }
    const progress_bar = progress.select('.progress-bar');
    const bg_progress_bar = progress.select('.bg-progress-bar');
    if(!bg_progress_bar){
        return;
    }
    setTimeout((event) => {
        let now = parseInt(bg_progress_bar.attribute('aria-valuenow'));
        let reverse = bg_progress_bar.attribute('aria-reverse');
        if(reverse){
            now--;
            if(now <= 0){
                bg_progress_bar.attribute('delete', 'aria-reverse');
            }
        } else {
            now++;
        }

        bg_progress_bar.css('width', now + '%');
        bg_progress_bar.attribute('aria-valuenow', now);
        if(now >= 100){
            //now = 0;
            bg_progress_bar.css('width', now + '%');
            bg_progress_bar.attribute('aria-valuenow', now);
            bg_progress_bar.attribute('aria-reverse', true);
        }
        view.progress();
    }, 100);
}

view.title = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const is_link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
    if(is_link){
        const nav = section.select('.nav');
        const active = nav.select('.active');
        if(active){
            active.removeClass('active');
        }
        is_link.addClass('active');
        view.body();
        return;
    }
    const nav = section.select('.nav');
    const li = create('li', 'nav-item');
    const a = create('a', 'nav-link ' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
    a.data('frontend-url', "");
    a.data('url', "");
    a.html("<span class='title'>{{$request.node.name}}</span><i class=\"fas fa-window-close\"></i>");
    li.append(a);
    nav.append(li);
    a.on('click', (event) => {
        if(event.detail === 1){
            const ul = li.parentNode;
            const active = ul.select('.active');
            if(active){
                active.removeClass('active');
            }
            a.addClass('active');
            view.body('show');
        } else {
            //reload from data url & frontend url
        }
    });
    const i = a.select('.fa-window-close');
    if(i){
        i.on('click', (event) => {
            event.stopPropagation();
            li.remove();
            view.body('remove');
            const menuItem = section.select('.'+ "{{$module}}" + '-' + "{{$submodule}}" + '-' + 'settings');
            if(menuItem){
                menuItem.trigger('click');
            }
        });
    }
    const ul = li.parentNode;
    const active = ul.select('.active');
    if(active){
        active.removeClass('active');
    }
    a.addClass('active');
}

view.body = (action) => {
    if(is.empty(action)){
        action = 'show';
    }
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let body;
    let selected;
    switch(action){
        case 'show' :
            body = section.select('.card-body');
            body.addClass('d-none');
            selected = section.select('.card-body-view-' + "{{$request.node.key}}");
            if(selected){
                selected.removeClass('d-none');
            }
            break;
        case 'remove' :
            body = section.select('.card-body');
            body.addClass('d-none');
            selected = section.select('.card-body-view-' + "{{$request.node.key}}");
            if(selected){
                selected.remove();
            }
            break;
    }
}


view.init = () => {
    view.body();
    view.title();
    view.progress();
};

ready(() => {
    view.init();
});
