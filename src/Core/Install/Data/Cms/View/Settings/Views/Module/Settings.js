//{{R3M}}
import user from "/Module/User.js";
import menu from "/Module/Menu.js";
import create from "/Module/Create.js";
import dialog from "/Module/Dialog.js";
import { getSectionByName } from "/Module/Section.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { contains, replace } from "/Module/String.js";
import { uuid } from "/Module/Web.js";

import upload from "/Settings/Views/Module/Upload.js";

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
    if(!selectInverse){
        return;
    }
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

settings.upload = ({
   url,
   token,
   upload_max_filesize,
   target,
   redirect_url,
   message,
   form
}) => {
    require(
        [
            root() + 'Dropzone/5.9.2/Min/dropzone.min.js?' + version(),
            root() + 'Dropzone/5.9.2/Min/dropzone.min.css?' + version()
        ],
        function(){
            if(token){
                upload.init({
                    url : url,
                    token: token,
                    upload_max_filesize: upload_max_filesize,
                    target : target,
                    message: message,
                    form: form
                });
            } else {
                redirect(redirect_url)
            }
        }
    );
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

settings.node = {};
settings.node.item = {};
settings.node.list = {};

settings.node.item.delete = ({node, section, target}) => {
    if(!node){
        return;
    }
    if(!section){
        return;
    }
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
                            menuItem.data('limit', "{{$request.limit}}");
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

settings.node.item.rename = ({node, section, target}) => {
    if(!node){
        return;
    }
    if(!section){
        return;
    }
    node.on('click', (event) => {
        let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.rename.message'))}}";
        message = _('prototype').string.replace('{{$name}}', node.data('name'), message);
        message += '<br><input type="hidden" name="node.source" value="' + node.data('source') +
            '"/><label>' +
            "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.rename.destination.label')}}" +
            '</label><input type="text" name="node.destination" />'
        ;
        let dialog_create = dialog.create({
            title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.rename.title')}}",
            message : message,
            buttons : [
                {
                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.rename.button.ok')}}"
                },
                {
                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.rename.button.cancel')}}"
                }
            ],
            section : section,
            className : "dialog dialog-rename",
            form : {
                name : "dialog-rename",
                url : node.data('url'),
            }
        });
        const form = dialog_create.select('form');
        if(form){
            form.on('submit', (event) => {
                if(node.data('has', 'url')){
                    let filter = {
                        type : "{{$request.filter.type}}",
                        extension : "{{$request.filter.extension}}",
                    };
                    let data = {
                        ...form.data('serialize'),
                        request : {
                            method : node.data('request-method') ? node.data('request-method') : "PATCH"
                        },
                        limit: "{{$request.limit}}",
                        filter: filter
                    };
                    header('authorization', 'Bearer ' + user.token());
                    request(node.data('url'), data, (url, response) => {
                        const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                        if(response?.page){
                            if(menuItem){
                                menuItem.data('page', response.page);
                            }
                        }
                        if(menuItem){
                            menuItem.data('filter-type', filter.type);
                            menuItem.data('limit', "{{$request.limit}}");
                        }
                        let source;
                        let destination;
                        for(let attribute in data){
                            let item  = data[attribute];
                            if(item.name === 'node.source'){
                                source = item.value;
                            }
                            else if(item.name === 'node.destination'){
                                destination = item.value;
                            }
                        }
                        if(source){
                            source = _('_').basename(source);
                        }
                        if(response?.class === "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.rename.response.class')}}"){
                            let error = '';
                            if(response?.message === "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.rename.response.message.file.exist')}}"){
                                error = "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.rename.file.exist')}}";
                            }
                            error = _('prototype').string.replace("{$destination}", destination, error);
                            let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.rename.message'))}}";
                            message = _('prototype').string.replace("{$source}", source, message);
                            message = _('prototype').string.replace("{$destination}", destination, message);

                            let dialog_error = dialog.create({
                                title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.rename.title')}}",
                                message : message,
                                error : error,
                                buttons : [
                                    {
                                        text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.rename.button.ok')}}"
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
                        settings.menuItem();
                        dialog_create.remove();
                        menu.dispatch(section, target);
                    });
                }
            });
            const input = form.select('input[type="text"]');
            if(input){
                input.focus();
            }
        }
    });
}

settings.node.item.create_dir = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.create.directory.message'))}}";
        message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
        message += '<p><label>' +
            "{{__($__.module + '.' + $__.submodule + '.dialog.create.directory.name')}}" +
            '</label><input type="text" name="node.name" value=""/></p>'
        ;
        let dialog_create = dialog.create({
            title: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.create.directory.title')}}",
            message: message,
            buttons: [
                {
                    text: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.create.directory.button.ok')}}"
                },
                {
                    text: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.create.directory.button.cancel')}}"
                }
            ],
            section: section,
            className: "dialog dialog-create-directory",
            form: {
                name: "dialog-create-directory",
                url: node.data('url'),
            }
        });
        let form = dialog_create.select('form');
        if(form){
            form.on('submit', (event) => {
                if(form.data('has', 'url')){
                    let data = form.data('serialize');
                    let filter = {
                        type : "{{$request.filter.type}}"
                    };
                    header('authorization', 'Bearer ' + user.token());
                    request(form.data('url'), data, (url, response) => {
                        if(response?.class === 'R3m\\Io\\Exception\\ErrorException'){
                            let error = [];
                            let message;
                            if(response?.message === 'Name cannot be empty...'){
                                message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.directory.empty.message'))}}";
                                error.push("{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.directory.empty.directory'))}}");
                            } else {
                                message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.directory.exist.message'))}}";
                                const input = dialog_create.select('input[name="node.name"]');
                                error.push(input.value);
                            }
                            let dialog_error = dialog.create({
                                title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.directory.title')}}",
                                message : message,
                                error : error,
                                buttons : [
                                    {
                                        text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.directory.button.ok')}}"
                                    }
                                ],
                                section : section,
                                className : "dialog dialog-error dialog-error-create-directory"
                            });
                            let form = dialog_error.select('form');
                            if(!form){
                                return;
                            }
                            form.on('submit', (event) => {
                                dialog_error.remove();
                                let form = dialog_create.select('form');
                                let input = form.select('input[name="node.name"]');
                                if(input){
                                    input.focus();
                                }
                            });
                            const button = form.select('button[type="submit"]');
                            if(button){
                                button.focus();
                            }
                        } else {
                            const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                            if(menuItem){
                                menuItem.data('filter-type', filter.type);
                                menuItem.data('limit', "{{$request.limit}}");
                            }
                            menu.dispatch(section, target);
                            dialog_create.remove();
                        }
                    });
                }
            });
        }
        const input = dialog_create.select('input[name="node.name"]');
        if(input){
            input.focus();
        }
    });
}

settings.node.item.create_file = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        if(node.data('has', 'frontend-url')){
            request(node.data('frontend-url'));
        }
    });
}

settings.node.item.create_symlink = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.create.symlink.message'))}}";
        message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
        message += '<p><label>' +
            "{{__($__.module + '.' + $__.submodule + '.dialog.create.symlink.source')}}" +
            '</label><input type="text" name="node.source" value=""/><br><label>' +
            "{{__($__.module + '.' + $__.submodule + '.dialog.create.symlink.destination')}}" +
            '</label><input type="text" name="node.destination" value=""/></p>'
        ;
        let dialog_create = dialog.create({
            title: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.create.symlink.title')}}",
            message: message,
            buttons: [
                {
                    text: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.create.symlink.button.ok')}}"
                },
                {
                    text: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.create.symlink.button.cancel')}}"
                }
            ],
            section: section,
            className: "dialog dialog-create-symlink",
            form: {
                name: "dialog-create-symlink",
                url: node.data('url'),
            }
        });
        let form = dialog_create.select('form');
        if(form){
            form.on('submit', (event) => {
                if(form.data('has', 'url')){
                    let data = form.data('serialize');
                    let filter = {
                        type : "{{$request.filter.type}}"
                    };
                    header('authorization', 'Bearer ' + user.token());
                    request(form.data('url'), data, (url, response) => {
                        if(response?.class === 'R3m\\Io\\Exception\\ErrorException'){
                            let error = [];
                            let source = dialog_create.select('input[name="node.source"]');
                            error.push('Source: ' + source.value);
                            let destination = dialog_create.select('input[name="node.destination"]');
                            error.push('Destination: ' + destination.value);
                            let dialog_error;
                            let message;
                            if(response?.message === 'Destination exists...') {
                                message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.symlink.destination.message'))}}";
                            } else {
                                message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.symlink.source.message'))}}";
                            }
                            dialog_error = dialog.create({
                                title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.symlink.title')}}",
                                message : message,
                                error : error,
                                buttons : [
                                    {
                                        text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.item.create.symlink.button.ok')}}"
                                    }
                                ],
                                section : section,
                                className : "dialog dialog-error dialog-error-create-symlink dialog-error-destination"
                            });
                            let form = dialog_error.select('form');
                            if(!form){
                                return;
                            }
                            form.on('submit', (event) => {
                                dialog_error.remove();
                                let form = dialog_create.select('form');
                                let input = form.select('input[name="node.source"]');
                                if(input){
                                    input.focus();
                                }
                            });
                            const button = form.select('button[type="submit"]');
                            if(button){
                                button.focus();
                            }
                        } else {
                            const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                            if(menuItem){
                                menuItem.data('filter-type', filter.type);
                                menuItem.data('limit', "{{$request.limit}}");
                            }
                            menu.dispatch(section, target);
                            dialog_create.remove();
                        }
                    });
                }
            });
        }
        const input = dialog_create.select('input[name="node.source"]');
        if(input){
            input.focus();
        }
    });
}

settings.node.list.delete = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
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
                    let url = node.data('url');
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
                    let data = {
                        nodeList : settings.get('selected'),
                        request : {
                            method : node.data('request-method') ? node.data('request-method') : "DELETE"
                        }
                    };
                    let filter = {
                        type : "{{$request.filter.type}}",
                        extension: "{{$request.filter.extension}}"
                    };
                    header('authorization', 'Bearer ' + user.token());
                    request(url, data, (url, response) => {
                        const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                        if(menuItem){
                            menuItem.data('filter-type', filter.type);
                            menuItem.data('limit', "{{$request.limit}}");
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

settings.node.list.copy = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        //make dialog move with where to copy to.
        let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.list.copy.message'))}}";
        message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
        message += '<p><label>' +
            "{{__($__.module + '.' + $__.submodule + '.dialog.list.copy.target.directory')}}" +
            '</label><input type="text" name="node.directory" value=""/></p>'
        ;
        let dialog_create = dialog.create({
            title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.copy.title')}}",
            message : message,
            buttons : [
                {
                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.copy.button.ok')}}"
                },
                {
                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.copy.button.cancel')}}"
                }
            ],
            section : section,
            className : "dialog dialog-copy",
            form : {
                name: "dialog-copy",
                url : node.data('url'),
            }
        });
        const form = dialog_create.select('form[name="dialog-copy"]');
        if(!form){
            return;
        }
        form.on('submit', (event) => {
            if(form.data('has', 'url')){
                let url = form.data('url');
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
                header('authorization', 'Bearer ' + user.token());
                let filter = {
                    type : "{{$request.filter.type}}",
                    extension: "{{$request.filter.extension}}"
                };
                let data = {
                    directory: section.select('input[name="node.directory"]')?.value,
                    nodeList: settings.get('selected'),
                    limit: "{{$request.limit}}",
                    filter: filter
                };
                request(url, data, (url, response) => {
                    dialog_create.remove();
                    const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                    if(response?.page){
                        if(menuItem){
                            menuItem.data('page', response.page);
                        }
                    }
                    if(menuItem){
                        menuItem.data('filter-type', filter.type);
                        menuItem.data('limit', "{{$request.limit}}");
                    }
                    if(response?.error){
                        let dialog_error = dialog.create({
                            title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.copy.title')}}",
                            message : "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.copy.message'))}}",
                            error : response.error,
                            buttons : [
                                {
                                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.error.list.copy.button.ok')}}"
                                }
                            ],
                            section : section,
                            className : "dialog dialog-error dialog-error-copy"
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

settings.node.list.move = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        //make dialog move with where to move to.
        let message = "{{sentences(__($__.module + '.' + $__.submodule + '.' + 'dialog.list.move.message'))}}";
        message = '<p>' +_('prototype').string.replace('{{$name}}', node.data('name'), message) + '</p>';
        message += '<p><label>' +
            "{{__($__.module + '.' + $__.submodule + '.dialog.list.move.target.directory')}}" +
            '</label><input type="text" name="node.directory" value=""/></p>'
        ;
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
                let url = node.data('url');
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
                header('authorization', 'Bearer ' + user.token());
                let filter = {
                    type : "{{$request.filter.type}}",
                    extension: "{{$request.filter.extension}}"
                };
                let data = {
                    directory: section.select('input[name="node.directory"]')?.value,
                    nodeList: settings.get('selected'),
                    limit: "{{$request.limit}}",
                    filter: filter
                };
                request(url, data, (url, response) => {
                    dialog_create.remove();
                    const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
                    if(response?.page){
                        if(menuItem){
                            menuItem.data('page', response.page);
                        }
                    }
                    if(menuItem){
                        menuItem.data('filter-type', filter.type);
                        menuItem.data('limit', "{{$request.limit}}");
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

settings.node.list.upload = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        let message = '<p><label>' +
            "{{__($__.module + '.' + $__.submodule + '.dialog.list.upload.target.directory')}}" +
            '</label><input type="text" name="node.directory" value=""/></p>'
        ;
        let dialog_create = dialog.create({
            title : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.title')}}",
            message : message,
            buttons : [
                {
                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.button.ok')}}"
                },
                {
                    text : "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.button.cancel')}}"
                }
            ],
            section : section,
            className : "dialog dialog-upload",
            form : {
                name: "dialog-upload",
                url : node.data('url'),
                data : [
                    {
                        name: "error-1",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.1')}}"
                    },
                    {
                        name: "error-2",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.2')}}"
                    },
                    {
                        name: "error-3",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.3')}}"
                    },
                    {
                        name: "error-4",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.4')}}"
                    },
                    {
                        name: "error-6",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.6')}}"
                    },
                    {
                        name: "error-7",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.7')}}"
                    },
                    {
                        name: "error-8",
                        value: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.error.8')}}"
                    }
                ]
            }
        });
        const form = dialog_create.select('form[name="dialog-upload"]');
        if(!form){
            return;
        }
        let upload_target = dialog_create.select('.body');
        settings.upload({
            url: "{{server.url('core')}}Settings/Server/Settings/Upload/",
            token: user.token(),
            upload_max_filesize: "1024 M",
            target: upload_target,
            redirect_url: "{{server.url('cms')}}User/Login/",
            message: "{{__($__.module + '.' + $__.submodule + '.' + 'dialog.list.upload.message')}}",
            form: form
        });
        form.on('submit', (event) => {
            dialog_create.remove();
            menu.dispatch(section, target);
        });
        const input = form.select('input[name="node.directory"]');
        if(input){
            input.focus();
        }
    });
}

settings.node.list.filter = ({node, section, target}) => {
    if (!node) {
        return;
    }
    if (!section) {
        return;
    }
    node.on('click', (event) => {
        if(node.data('has', 'url') && node.data('has', 'frontend-url')){
            let url = node.data('url');
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
            let data = {};
            header('authorization', 'Bearer ' + user.token());
            request(url, data, (url, response) => {
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
                settings.node.item.delete({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('item-rename')){
                settings.node.item.rename({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('item-create-dir')){
                settings.node.item.create_dir({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('item-create-file')){
                settings.node.item.create_file({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('item-create-symlink')){
                settings.node.item.create_symlink({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('list-copy')){
                settings.node.list.copy({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('list-delete')){
                settings.node.list.delete({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('list-move')){
                settings.node.list.move({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(node.hasClass('list-upload')){
                settings.node.list.upload({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else if(
                node.hasClass('list-filter-all') ||
                node.hasClass('list-filter-file') ||
                node.hasClass('list-filter-dir') ||
                node.hasClass('list-filter-tpl') ||
                node.hasClass('list-filter-js') ||
                node.hasClass('list-filter-json') ||
                node.hasClass('list-filter-css')
            ){
                settings.node.list.filter({
                    node : node,
                    section : section,
                    target: target
                });
            }
            else {
                node.on('click', (event) => {
                    if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                        let url = node.data('url');
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
                        header('Authorization', 'Bearer ' + user.token());
                        request(url, null, (url, response) => {
                            request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
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
            settings.node.item.delete({
                node : node,
                section : section,
                target: target
            });
        }
        else if(node.hasClass('item-create-dir')){
            settings.node.item.create_dir({
                node : node,
                section : section,
                target: target
            });
        }
        else if(node.hasClass('item-create-file')){
            settings.node.item.create_file({
                node : node,
                section : section,
                target: target
            });
        }
        else if(node.hasClass('item-create-symlink')){
            settings.node.item.create_symlink({
                node : node,
                section : section,
                target: target
            });
        }
        else if(node.hasClass('list-copy')){
            settings.node.list.copy({
                node : node,
                section : section,
                target: target
            });
        }
        else if(node.hasClass('list-delete')){
            settings.node.list.delete({
                node : node,
                section : section,
                target: target
            });
        }
        else if(node.hasClass('list-move')){
            settings.node.list.move({
                node : node,
                section : section,
                target: target
            });
        }
        else if(
            node.hasClass('list-filter-all') ||
            node.hasClass('list-filter-file') ||
            node.hasClass('list-filter-dir') ||
            node.hasClass('list-filter-tpl') ||
            node.hasClass('list-filter-js') ||
            node.hasClass('list-filter-json') ||
            node.hasClass('list-filter-css')
        ){
            settings.node.list.filter({
                node : node,
                section : section,
                target: target
            });
        }
        else {
            node.on('click', (event) => {
                if(node.data('has', 'url') && node.data('has', 'frontend-url')){
                    let url = node.data('url');
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
                    header('Authorization', 'Bearer ' + user.token());
                    request(url, null, (url, response) => {
                        request(node.data('frontend-url'), response, (frontendUrl, frontendResponse) => {
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

settings.deleteDialog = (data) => {
    if(!data?.node){
        return;
    }
    if(!data?.section){
        const selection = data.node.data('select');
        if(selection){
            data.section = select(selection);
            if(!data.section){
                return;
            }
        } else {
            return;
        }
    }
    if(!data?.target){
        return;
    }
    if(!data?.className){
        data.className = 'dialog dialog-delete';
    }
    if(!data?.title){
        data.title = 'Delete';
    }
    if(!is.empty(data.node.data('title'))){
        data.title = data.node.data('title');
    }
    const section = data.section;
    const target = data.target;
    const node = data.node;
    const dialog = create('div', data.className);
    const head = create('div', 'head');
    const body = create('div', 'body');
    const footer = create('div', 'footer');
    head.html('<h1>' + data?.title + '</h1><span class="close"><i class="fas fa-window-close"></i></span>');
    if(!is.empty(node.data('name'))){
        body.html('<p>' + "{{__($__.module + '.' + $__.submodule + '.module.' + $__.command + '.delete')}}" + ': ' + node.data('name') + '?<br></p>');
    } else {
        body.html('<p>' + "{{__($__.module + '.' + $__.submodule + '.module.' + $__.command + '.delete')}}" + '?<br></p>');
    }
    footer.html('<div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-submit">Yes</button></div><div class="w-50 d-inline-block text-center"><button type="button" class="btn btn-primary button-cancel">No</button></div>');
    dialog.appendChild(head);
    dialog.appendChild(body);
    dialog.appendChild(footer);
    section.appendChild(dialog);
    const close = head.select('.fa-window-close');
    if(close){
        close.on('click', (event) => {
            dialog.remove();
        });
    }
    const submit = footer.select('.button-submit');
    if(submit){
        submit.on('click', (event) => {
            if(node.data('has', 'url')){
                let data = {
                    request : {
                        method : node.data('request-method') ? node.data('request-method') : "DELETE"
                    }
                };
                header('authorization', 'Bearer ' + user.token());
                request(node.data('url'), data, (url, response) => {
                    menu.dispatch(section, target);
                });
            }
            dialog.remove();
        });
        submit.focus();
    }
    const cancel = footer.select('.button-cancel');
    if(cancel){
        cancel.on('click', (event) => {
            dialog.remove();
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
        if(body){
            body.addClass('d-none');
        }
        const selected = section.select('.card-body-' + "{{$command}}");
        if(selected){
            selected.removeClass('d-none');
        }
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

settings.menuItem = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const menuItem = section.select(".{{$module}}-{{$submodule}}-{{$command}}");
    if(menuItem){
        menuItem.data('filter-type', "{{$request.filter.type}}");
        menuItem.data('limit', "{{$request.limit}}");
    }
}

settings.onLoad = () => {
    settings.menuItem();
}

settings.init = () => {
    settings.body();
    settings.onLoad();
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
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Delete.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Move.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Copy.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Upload.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Create.Directory.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Create.File.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Create.Symlink.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + 'Dialog.Rename.css?' + version(),
            root() + "{{$require.module}}" + '/' + "{{$require.submodule}}" + '/Css/' + "{{$require.submodule|file.basename}}" + '.css?' + version()
        ],
        () => {
            settings.init();
        });
});
