//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import dialog from "/Module/Dialog.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { contains, replace } from "/Module/String.js";
let settings = {};

settings.get = (attribute) => {
    if(is.empty(attribute)){
        return _('_').collection("{{$__.module}}.{{$__.submodule}}." + 'settings');
    } else {
        return _('_').collection("{{$__.module}}.{{$__.submodule}}." + 'settings.' + attribute);
    }
}

settings.set = (attribute, value) => {
    _('_').collection("{{$__.module}}.{{$__.submodule}}." + 'settings.' + attribute, value);
}

settings.delete = (attribute) => {
    _('_').collection('delete', "{{$__.module}}.{{$__.submodule}}." + 'settings.' + attribute);
}

settings.data = (attribute, value) => {
    return _('_').collection("{{$__.module}}.{{$__.submodule}}." + 'settings.' + attribute, value);
}

settings.onSelectInverse = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let selectInverse = section.select('input[name="node.checkInverse"]')

    selectInverse.on('click', () => {
        let list = section.select('.card-' + "{{$subcommand}}" + '-' + "{{$command}}" + ' tr input[type="checkbox"]');
        let selected = settings.get('selected');
        if(is.empty(selected)){
            selected = [];
        }
        if(is.nodeList(list)){
            let index;
            for(index = 1; index < list.length; index++){
                let node = list[index];
                if(node.checked){
                    selected = selected.filter((item) => {
                        return item !== node.value;
                    });
                    node.checked = false;
                } else {
                    node.checked = true;
                    selected.push(node.value);
                }
            }
        } else if(list){
            let node = list;
            if(node.checked){
                selected = selected.filter((item) => {
                    return item !== node.value;
                });
                node.checked = false;
            } else {
                node.checked = true;
                selected.push(node.value);
            }
        }
        settings.set('selected', selected);
    });
}

settings.onDoubleClick = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.card-' + "{{$subcommand}}" + '-' + "{{$command}}" + ' tr');
    console.log(list);
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            node.on('dblclick', (event) => {
                if(node.data('has', 'url')){
                    header('Authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        console.log(response);
                        console.log(node.data('frontend-url'));
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                            console.log(frontendResponse);
                        });
                    });
                }
            });
        }
    } else if(list) {
        let node = list;
        node.on('dblclick', (event) => {
            if(node.data('has', 'url')){
                header('Authorization', 'Bearer ' + user.token());
                request(node.data('url'), null, (url, response) => {
                    request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                    });
                });
            }
        });

    }
}

settings.page = (type, section, data) => {
    console.log(data);
    if(
        is.array(data?.select)
    ){
        let index;
        for(index=0; index < data.select.length; index++){
            let item = data.select[index];
            if(
                item?.name
            ){
                const menuItem = section.select(item.name);
                if(menuItem) {
                    let page = "{{request('page')}}";
                    page = parseInt(page);
                    switch (type){
                        case 'current' :
                            page = data.page;
                            console.log('current', page);
                            menuItem.data('page', page);
                            break;
                        case 'next' :
                            page++;
                            menuItem.data('page', page);
                            break;
                        case 'previous' :
                            page--;
                            menuItem.data('page', page);
                            break;
                    }
                }
            }
        }
    } else {
        if(data?.select){
            const menuItem = section.select(data.select);
            if(menuItem){
                let page = "{{request('page')}}";
                page = parseInt(page);
                switch (type){
                    case 'current' :
                        page = data.page;
                        console.log('current', page);
                        menuItem.data('page', page);
                        break;
                    case 'next' :
                        page++;
                        menuItem.data('page', page);
                        break;
                    case 'previous' :
                        page--;
                        menuItem.data('page', page);
                        break;
                }
            }
        }
    }
}

settings.selected = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const selected = settings.get('selected');
    const input = section.select('input[name="node.nodeList[]"]');
    if(is.nodeList(input)){
        let index;
        for(index=0; index < input.length; index++){
            let node = input[index];
            if(in_array(node.value, selected)){
                node.checked = true;
            }
        }
    } else if(input){
        let node = input;
        if(in_array(node.value, selected)){
            node.checked = true;
        }
    }
}

settings.actions = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const input = section.select('input[name="node.nodeList[]"]');
    if(is.nodeList(input)){
        let index;
        for(index=0; index < input.length; index++){
            let node = input[index];
            node.on('input', (event) => {
                //event.preventDefault();
                event.stopPropagation();
                if(node.checked){
                    let selected = settings.get('selected');
                    if(is.empty(selected)){
                        selected = [];
                    }
                    selected.push(node.value);
                    settings.set('selected', selected);
                    //add item to nodeList
                } else {
                    let selected = settings.get('selected');
                    if(is.empty(selected)){
                        selected = [];
                    }
                    selected = selected.filter((item) => {
                        return item !== node.value;
                    });
                    settings.set('selected', selected);
                }
            });
        }
    } else if(input){
        let node = input;
        node.on('input', (event) => {
            //event.preventDefault();
            event.stopPropagation();
            if(node.checked){
                let selected = settings.get('selected');
                if(is.empty(selected)){
                    selected = [];
                }
                selected.push(node.value);
                settings.set('selected', selected);
            } else {
                let selected = settings.get('selected');
                if(is.empty(selected)){
                    selected = [];
                }
                selected = selected.filter((item) => {
                    return item !== node.value;
                });
                settings.set('selected', selected);
            }
        });
    }
}

settings.options = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    let list = section.select('.dropdown-item');
    if(is.nodeList(list)){
        let index;
        for(index=0; index < list.length; index++){
            let node = list[index];
            if(node.hasClass('item-delete')){
                node.on('click', (event) => {
                    let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.message'))}}";
                    message = _('prototype').string.replace('{{$name}}', node.data('name'), message);
                    let dialog_create = dialog.create({
                        title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.title')}}",
                        message : message,
                        buttons : [
                            {
                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.button.ok')}}"
                            },
                            {
                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.button.cancel')}}"
                            }
                        ],
                        section : section,
                        className : "dialog dialog-delete",
                        form : {
                            name : "dialog-delete",
                            url : node.data('url'),
                        }
                    });
                    const form = dialog_create.select('form');
                    if(form){
                        form.on('submit', (event) => {
                            if(node.data('has', 'url')){
                                let data = {
                                    request : {
                                        method : node.data('request-method') ? node.data('request-method') : "DELETE"
                                    }
                                };
                                let filter = {
                                    type : "{{$request.filter.type}}"
                                };
                                header('authorization', 'Bearer ' + user.token());
                                request(node.data('url'), data, (url, response) => {
                                    const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                    if(menuItem){
                                        menuItem.data('filter-type', filter.type);
                                    }
                                    dialog_create.remove();
                                    menu.dispatch(section, target);
                                });
                            }
                        });
                        const submit = form.select('.button-submit');
                        if(submit){
                            submit.focus();
                        }

                    }
                });
            }
            else if(node.hasClass('item-new-dir')){
                node.on('click', (event) => {
                    let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.new.directory.message'))}}";
                    message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
                    message += '<p><label>' + "{{__($__.module + '.' + $__.submodule + '.dialog.new.directory.name')}}" + '</label><input type="text" name="node.name" value=""/></p>'
                    let dialog_create = dialog.create({
                        title: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.new.directory.title')}}",
                        message: message,
                        buttons: [
                            {
                                text: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.new.directory.button.ok')}}"
                            },
                            {
                                text: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.new.directory.button.cancel')}}"
                            }
                        ],
                        section: section,
                        className: "dialog dialog-new-directory",
                        form: {
                            name: "dialog-new-directory",
                            url: node.data('url'),
                        }
                    });
                });
            }
            else if(node.hasClass('list-delete')){
                node.on('click', (event) => {
                    let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.message'))}}";
                    let dialog_create = dialog.create({
                        title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.title')}}",
                        message : message,
                        buttons : [
                            {
                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.button.ok')}}"
                            },
                            {
                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.button.cancel')}}"
                            }
                        ],
                        section : section,
                        className : "dialog dialog-delete",
                        form : {
                            name : "dialog-delete",
                            url : node.data('url'),
                        }
                    });
                    const form = dialog_create.select('form');
                    if(form){
                        form.on('submit', (event) => {
                            if(node.data('has', 'url')){
                                let data = {
                                    nodeList : settings.get('selected'),
                                    request : {
                                        method : node.data('request-method') ? node.data('request-method') : "DELETE"
                                    }
                                };
                                let filter = {
                                    type : "{{$request.filter.type}}"
                                };
                                header('authorization', 'Bearer ' + user.token());
                                request(node.data('url'), data, (url, response) => {
                                    const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                    if(menuItem){
                                        menuItem.data('filter-type', filter.type);
                                    }
                                    dialog_create.remove();
                                    settings.delete('selected');
                                    menu.dispatch(section, target);
                                });
                            }
                        });
                    }
                    const submit = dialog_create.select('.button-submit');
                    if(submit){
                        submit.focus();
                    }
                });
            }
            else if(node.hasClass('list-move')){
                node.on('click', (event) => {
                    //make dialog move with where to move to.
                    let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.message'))}}";
                    message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
                    message += '<p><label>' + "{{__($__.module + '.' + $__.submodule + '.dialog.list.move.target.directory')}}" + '</label><input type="text" name="node.directory" value=""/></p>'
                    let dialog_create = dialog.create({
                        title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.title')}}",
                        message : message,
                        buttons : [
                            {
                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.button.ok')}}"
                            },
                            {
                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.button.cancel')}}"
                            }
                        ],
                        section : section,
                        className : "dialog dialog-move",
                        form : {
                            name: "dialog-move",
                            url : node.data('url'),
                        }
                    });
                    const form = dialog_create.select('form[name="dialog-move"]');
                    if(!form){
                        return;
                    }
                    form.on('submit', (event) => {
                        if(form.data('has', 'url')){
                            header('authorization', 'Bearer ' + user.token());
                            let filter = {
                                type : "{{$request.filter.type}}"
                            };
                            let data = {
                                directory: section.select('input[name="node.directory"]')?.value,
                                nodeList: settings.get('selected'),
                                limit: "{{$request.limit}}",
                                filter: filter
                            };
                            request(form.data('url'), data, (url, response) => {
                                dialog_create.remove();
                                if(response?.page){
                                    const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                    if(menuItem){
                                        menuItem.data('page', response.page);
                                    }
                                }
                                const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                if(menuItem){
                                    menuItem.data('filter-type', filter.type);
                                }
                                if(response?.error){
                                    let dialog_error = dialog.create({
                                        title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.move.title')}}",
                                        message : "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.move.message'))}}",
                                        error : response.error,
                                        buttons : [
                                            {
                                                text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.move.button.ok')}}"
                                            }
                                        ],
                                        section : section,
                                        className : "dialog dialog-error dialog-error-move"
                                    });
                                    const form = dialog_error.select('form');
                                    if(!form){
                                        return;
                                    }
                                    form.on('submit', (event) => {
                                        dialog_error.remove();
                                    });
                                    const button = form.select('button[type="submit"]');
                                    if(button){
                                        button.focus();
                                    }
                                }
                                settings.delete('selected')
                                menu.dispatch(section, target);
                            });
                        }
                    });
                    const input = form.select('input[name="node.directory"]');
                    if(input){
                        input.focus();
                    }
                });
            }

            else if(
                node.hasClass('list-filter-file-dir') ||
                node.hasClass('list-filter-file') ||
                node.hasClass('list-filter-dir')
            ){
                node.on('click', (event) => {
                    if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                        let data = {};
                        request(node.data('url'), data, (url, response) => {
                            let filter = section.select('.dropdown .filter-type');
                            if(filter){
                                filter.text = node.text;
                            }
                            request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                                settings.selected();
                            });
                        });
                    }
                });
            }
            else {
                node.on('click', (event) => {
                    if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                        header('Authorization', 'Bearer ' + user.token());
                        request(node.data('url'), null, (url, response) => {
                            request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                                console.log('frontend-url2');
                            });
                        });
                    }
                    else if(node.data('has', 'frontend-url')){
                        request(node.data('frontend-url'), null, (url, response) => {
                        });
                    }
                });
            }
        }
    }
    else if(list){
        let node = list;
        if(node.hasClass('item-delete')){
            node.on('click', (event) => {
                let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.message'))}}";
                message = _('prototype').string.replace('{{$name}}', node.data('name'), message);
                let dialog_create = dialog.create({
                    title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.title')}}",
                    message : message,
                    buttons : [
                        {
                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.button.ok')}}"
                        },
                        {
                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.delete.button.cancel')}}"
                        }
                    ],
                    section : section,
                    className : "dialog dialog-delete",
                    form : {
                        name : "dialog-delete",
                        url : node.data('url'),
                    }
                });
                const form = dialog_create.select('form');
                if(form){
                    form.on('submit', (event) => {
                        if(node.data('has', 'url')){
                            let data = {
                                request : {
                                    method : node.data('request-method') ? node.data('request-method') : "DELETE"
                                }
                            };
                            let filter = {
                                type : "{{$request.filter.type}}"
                            };
                            header('authorization', 'Bearer ' + user.token());
                            request(node.data('url'), data, (url, response) => {
                                const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                if(menuItem){
                                    menuItem.data('filter-type', filter.type);
                                }
                                dialog_create.remove();
                                menu.dispatch(section, target);
                            });
                        }
                    });
                    const submit = form.select('.button-submit');
                    if(submit){
                        submit.focus();
                    }

                }
            });
        }
        else if(node.hasClass('list-delete')){
            node.on('click', (event) => {
                let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.message'))}}";
                let dialog_create = dialog.create({
                    title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.title')}}",
                    message : message,
                    buttons : [
                        {
                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.button.ok')}}"
                        },
                        {
                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.delete.button.cancel')}}"
                        }
                    ],
                    section : section,
                    className : "dialog dialog-delete",
                    form : {
                        name : "dialog-delete",
                        url : node.data('url'),
                    }
                });
                const form = dialog_create.select('form');
                if(form){
                    form.on('submit', (event) => {
                        if(node.data('has', 'url')){
                            let data = {
                                nodeList : settings.get('selected'),
                                request : {
                                    method : node.data('request-method') ? node.data('request-method') : "DELETE"
                                }
                            };
                            let filter = {
                                type : "{{$request.filter.type}}"
                            };
                            header('authorization', 'Bearer ' + user.token());
                            request(node.data('url'), data, (url, response) => {
                                const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                if(menuItem){
                                    menuItem.data('filter-type', filter.type);
                                }
                                dialog_create.remove();
                                settings.delete('selected');
                                menu.dispatch(section, target);
                            });
                        }
                    });
                }
                const submit = dialog_create.select('.button-submit');
                if(submit){
                    submit.focus();
                }
            });
        }
        else if(node.hasClass('list-move')){
            node.on('click', (event) => {
                //make dialog move with where to move to.
                let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.message'))}}";
                message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
                message += '<p><label>' + "{{__($__.module + '.' + $__.submodule + '.dialog.list.move.target.directory')}}" + '</label><input type="text" name="node.directory" value=""/></p>'
                let dialog_create = dialog.create({
                    title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.title')}}",
                    message : message,
                    buttons : [
                        {
                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.button.ok')}}"
                        },
                        {
                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.button.cancel')}}"
                        }
                    ],
                    section : section,
                    className : "dialog dialog-move",
                    form : {
                        name: "dialog-move",
                        url : node.data('url'),
                    }
                });
                const form = dialog_create.select('form[name="dialog-move"]');
                if(!form){
                    return;
                }
                form.on('submit', (event) => {
                    if(form.data('has', 'url')){
                        header('authorization', 'Bearer ' + user.token());
                        let filter = {
                            type : "{{$request.filter.type}}"
                        };
                        let data = {
                            directory: section.select('input[name="node.directory"]')?.value,
                            nodeList: settings.get('selected'),
                            limit: "{{$request.limit}}",
                            filter: filter
                        };
                        request(form.data('url'), data, (url, response) => {
                            dialog_create.remove();
                            if(response?.page){
                                const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                                if(menuItem){
                                    menuItem.data('page', response.page);
                                }
                            }
                            const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                            if(menuItem){
                                menuItem.data('filter-type', filter.type);
                            }
                            if(response?.error){
                                let dialog_error = dialog.create({
                                    title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.move.title')}}",
                                    message : "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.move.message'))}}",
                                    error : response.error,
                                    buttons : [
                                        {
                                            text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.move.button.ok')}}"
                                        }
                                    ],
                                    section : section,
                                    className : "dialog dialog-error dialog-error-move"
                                });
                                const form = dialog_error.select('form');
                                if(!form){
                                    return;
                                }
                                form.on('submit', (event) => {
                                    dialog_error.remove();
                                });
                                const button = form.select('button[type="submit"]');
                                if(button){
                                    button.focus();
                                }
                            }
                            settings.delete('selected')
                            menu.dispatch(section, target);
                        });
                    }
                });
                const input = form.select('input[name="node.directory"]');
                if(input){
                    input.focus();
                }
            });
        }

        else if(
            node.hasClass('list-filter-all') ||
            node.hasClass('list-filter-file') ||
            node.hasClass('list-filter-dir')
        ){
            node.on('click', (event) => {
                if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                    let data = {};
                    request(node.data('url'), data, (url, response) => {
                        let filter = section.select('.dropdown .filter-type');
                        if(filter){
                            filter.text = node.text;
                        }
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                            settings.selected();
                        });
                    });
                }
            });
        }
        else {
            node.on('click', (event) => {
                console.log('click2');
                if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                    console.log('has2');
                    header('Authorization', 'Bearer ' + user.token());
                    request(node.data('url'), null, (url, response) => {
                        console.log('url2');
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                            console.log('frontend-url2');
                        });
                    });
                }
                else if(node.data('has', 'frontend-url')){
                    request(node.data('frontend-url'), null, (url, response) => {

                    });
                }
            });
        }
    }
}

settings.pagination = (target) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const buttons = section.select('tfoot button');
    if(!buttons){
        return;
    }
    if(is.nodeList(buttons)){
        let index;
        for(index=0; index < buttons.length; index++){
            let button = buttons[index];
            button.on('click', () => {
                let url = button.data('url');
                if(contains(url, "{node.domain}") !== false){
                    const section = getSectionByName('main-content');
                    if(!section){
                        return;
                    }
                    const domain = section.select('input[name="node.domain"]');
                    if(!domain){
                        return;
                    }
                    url = replace("{node.domain}", domain.value, url);
                }
                if(button.data('has', 'page')){
                    const section = getSectionByName('main-content');
                    if(!section){
                        return;
                    }
                    target.page = button.data('page');
                    target.page = parseInt(target.page);
                    settings.page('current', section, target);
                }
                header('Authorization', 'Bearer ' + user.token());
                request(url, null, (url, response) => {
                    request(button.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
                        settings.selected();
                    });
                });
            });
        }
    }
    else if(buttons){
        let button = buttons;
        button.on('click', () => {
            let url = button.data('url');
            if(contains(url, "{node.domain}") !== false){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                const domain = section.select('input[name="node.domain"]');
                if(!domain){
                    return;
                }
                url = replace("{node.domain}", domain.value, url);
            }
            if(button.data('has', 'page')){
                const section = getSectionByName('main-content');
                if(!section){
                    return;
                }
                target.page = button.data('page');
                target.page = parseInt(target.page);
                settings.page('current', section, target);
            }
            header('Authorization', 'Bearer ' + user.token());
            request(url, null, (url, response) => {
                request(button.data('frontend-url'), response, (frontendUrl, frontendResponse) => {

                });
            });
        });
    }
}

settings.body = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const item = section.select('.' + "{{$module}}" + '-' + "{{$submodule}}" + '-' +  "{{$command}}");
    if(item.data('is-hidden')){
        item.data('delete', 'is-hidden');
    } else {
        const body = section.select('.card-body');
        body.addClass('d-none');
        const selected = section.select('.card-body-' + "{{$command}}");
        selected.removeClass('d-none');
    }
}

settings.search = () => {
    const section = getSectionByName('navigation');
    if(!section){
        return;
    }
    const form = section.select('form[name="search"]');
    if(!form){
        return;
    }
    if(
        form.data('module') === "{{$module}}" &&
        form.data('submodule') === "{{$submodule}}" &&
        form.data('command') === "{{$command}}"
    ){
        return;
    }
    form.data('url', "{{server.url('core')}}{{$require.module}}/{{$require.submodule}}/{{$require.command}}/{node.domain}");
    form.data('frontend-url', "{{route.get(route.prefix() + '-' + $module + '-' + $submodule + '-' + $command + '-body')}}");
    form.data('module', "{{$module}}");
    form.data('submodule', "{{$submodule}}");
    form.data('command', "{{$command}}");
    const input = form.select('input[type="search"]');
    if(!input){
        return;
    }
    form.on('submit', (event) => {
        event.preventDefault();
        let content = getSectionByName('main-content');
        if(!content){
            return;
        }
        let nav = content.select('.nav');
        if(!nav){
            return;
        }
        let active = nav.select('.nav-link.active');
        if(!active){
            return;
        }
        console.log("{{$module}}-{{$submodule}}-{{$command}}");
        console.log(active);
        if(!active.hasClass("{{$module}}-{{$submodule}}-{{$command}}")){
            input.value = '';
            return;
        }
        let url = form.data('url');
        if(!url){
            return;
        }
        let split = url.split('?');
        if(split[1] && input.value.length > 0){
            url += '&q=' + input.value
        } else if(input.value.length > 0) {
            url += '?q=' + input.value
        }
        let frontend_url = form.data('frontend-url');
        if(!frontend_url){
            return;
        }
        if(contains(url, "{node.domain}") !== false){
            const section = getSectionByName('main-content');
            if(!section){
                return;
            }
            const domain = section.select('input[name="node.domain"]');
            if(!domain){
                return;
            }
            url = replace("{node.domain}", domain.value, url);
        }
        request(url,null, (response_url, response) => {
            request(frontend_url, response, (frontend_response_url, frontend_response) => {
            });
        });
    });
    input.on('keyup', (event) => {
        form.trigger('submit');
    });
}

settings.init = () => {
    settings.body();
    settings.onSelectInverse();
    settings.onDoubleClick();
    settings.actions({
        select: ".{{$module}}-{{$submodule}}-{{$command}}",
        event: new MouseEvent("dblclick")
    });
    settings.options({
        select: ".{{$module}}-{{$submodule}}-{{$command}}",
        event: new MouseEvent("dblclick")
    });
    settings.search();
    settings.pagination({
        select: ".{{$module}}-{{$submodule}}-{{$command}}"
    });
}

ready(() => {
    require(
    [
        root() + 'Dialog/Css/Dialog.css?' + version(),
        root() + 'Dialog/Css/Dialog.Delete.css?' + version(),
        root() + 'Dialog/Css/Dialog.Move.css?' + version(),
        root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + "{{$require.submodule|file.basename}}" + '.css?' + version()
    ],
    () => {
        settings.init();
    });
});
