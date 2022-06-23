//{{R3M}}
import user from "/Module/User.js";
import create from "/Module/Create.js";
import menu from "/Module/Menu.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";
import { contains, replace } from "/Module/String.js";

let edit = {};

edit.title = () => {
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
        edit.body();
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
            edit.body('show');
            let pre = section.select('.card-body-' + "{{$request.node.key}} pre");
            if(pre){
                let editor = _('_').collection('source.editor.' + pre.id);
                if(editor){
                    editor.focus();
                }
                console.log(editor);
            }
        } else {
            //reload from data url & frontend url
        }
    });
    const i = a.select('.fa-window-close');
    if(i){
        i.on('click', (event) => {
            event.stopPropagation();
            li.remove();
            edit.body('remove');
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

edit.body = (action) => {
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
            selected = section.select('.card-body-' + "{{$request.node.key}}");
            selected.removeClass('d-none');
            break;
        case 'remove' :
            body = section.select('.card-body');
            body.addClass('d-none');
            selected = section.select('.card-body-' + "{{$request.node.key}}");
            selected.remove();
            break;
    }
}

edit.form = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    form.on('submit', ( event ) => {
        event.preventDefault();
        header('Authorization', 'Bearer ' + user.token());
        let data = form.data('serialize');
        let url = form.data('url');
        const section = getSectionByName('main-content');
        if(!section){
            return;
        }
        const domain = section.select('input[name="node.domain"]');
        if(!domain){
            return;
        }
        if(contains(url, "{node.domain}") !== false){
            url = replace("{node.domain}", domain.value, url);
        } else {
            data.push({
                name: "node.domain",
                value: domain.value
            });
        }
        const pre = form.select('pre[name="node.content"]');
        if(!pre){
            return;
        }
        data.push({
            name : "node.content",
            value: pre.data('content')
        });
        form.request(url, data, (url, response) => {
            if(response?.error){
                const dialog_save_as = section.select('.dialog-save-as');
                if(dialog_save_as){
                   alert('dialog error');
                } else {
                    data.push({
                        name: "error",
                        value: response.error
                    });
                    request(form.data('url-error'), data, ( urlError, responseError ) => {

                    });
                }
            }
            else if(
                response?.class &&
                response.class === 'R3m\\Io\\Exception\\FileExistException'
            ){
                const dialog = form.select('.dialog-save-as');
                if(!dialog){
                    return;
                }
                const error = dialog.select('.body .alert');
                if(!error){
                    const label = dialog.select('label');
                    let div = create('div', 'alert alert-danger');
                    div.html(response?.message)
                    if(is.nodeList(label)){
                        label[0].parentNode.insertBefore(div, label[0]);
                    }
                    else if(label){
                        label.parentNode.insertBefore(div, label);
                    }
                } else {
                    error.html(response?.message);
                }
            } else {
                _('_').collection('delete', 'source.editor.' + pre.id);
                menu.dispatch(section, target);
            }
        });
    });
}

edit.onUpdate = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const input = form.select('input[name="node.name"]');
    if(!input){
        return;
    }
    input.on('change', (event) => {
        const link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(input.value);
            }
        }
    });
    input.on('keyup', (event) => {
        const link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(input.value);
            }
        }
    });
}

edit.focus = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let pre = section.select('.card-body-' + "{{$request.node.key}} pre");
    if(pre){
        let editor = _('_').collection('source.editor.' + pre.id);
        if(editor){
            editor.focus();
        }
    }
}

edit.dialogSaveAs = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = section.select('.card-body-' + "{{$request.node.key}}");
    if(!selected){
        return;
    }
    const form = selected.select('form');
    if(!form){
        return;
    }
    const dialog = form.select('.dialog-save-as');
    if(!dialog){
        return;
    }
    const close = dialog.select('.close');
    if(!close){
        return;
    }
    close.on('click', (event) => {
        const link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
        const name_old = form.select('input[name="node.name_old"]');
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(name_old.value);
            }
        }
        const name = form.select('input[name="node.name"]');
        if(name){
            name.value = name_old.value;
        }
        const alert = dialog.select('.alert');
        if(alert){
            alert.remove();
        }
        dialog.addClass('d-none');
    });
    const cancel = dialog.select('.button-cancel');
    cancel.on('click', (event) => {
        const link = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' + "{{$command}}" + '-' + "{{$request.node.key}}");
        const name_old = form.select('input[name="node.name_old"]');
        if(link){
            const title = link.select('.title');
            if(title){
                title.html(name_old.value);
            }
        }
        const name = form.select('input[name="node.name"]');
        if(name){
            name.value = name_old.value;
        }
        const alert = dialog.select('.alert');
        if(alert){
            alert.remove();
        }
        dialog.addClass('d-none');
    });
    const submit = dialog.select('.button-submit');
    if(!submit){
        return;
    }
    submit.on('click', (event) => {
        form.trigger('submit');
    });
}

edit.init = () => {
    edit.body();
    edit.title();
    edit.dialogSaveAs();
    edit.form({
        select : [
            {
                name : ".{{$module}}-{{$submodule}}-{{$command}}-{{$request.node.key}} .fa-window-close",
                event : new MouseEvent("click"),
                hidden : true
            },
            {
                name : ".{{$module}}-{{$submodule}}-settings",
                event : new MouseEvent("dblclick")
            }
        ]
    });
    edit.onUpdate();
    edit.focus();
};

ready(() => {
    require(
    [
        root() + "{{$require.module}}" + '/'+ "{{$require.submodule}}"+'/Css/Edit.css?' + version(),
        root() + 'Dialog/Css/Dialog.Save.As.css?' + version(),
    ],
    () => {
        edit.init();
    });
});
