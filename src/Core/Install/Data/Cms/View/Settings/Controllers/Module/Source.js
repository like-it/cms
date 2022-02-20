//{{R3M}}
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";
import { contains, replace } from "/Module/String.js";

let source = {};

source.get = (attribute) => {
    if(is.empty(attribute)){
        return _('_').collection('source');
    } else {
        return _('_').collection('source.' + attribute);
    }
}

source.set = (attribute, value) => {
    _('_').collection('source.' + attribute, value);
}

source.data = (attribute, value) => {
    return _('_').collection('source.' + attribute, value);
}

source.panel = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body-' + "{{$request.node.key}}");
    if(!body){
        return;
    }
    let editor = source.get('editor.' + "{{$pre.id}}");
    if(!editor){
        return;
    }
    editor.on('change', (e) => {
        if(editor.session.getUndoManager().hasUndo()){
            let tr = body.select('.panel .undo');
            tr.removeClass('disabled');
        } else {
            let tr = body.select('.panel .undo');
            tr.addClass('disabled');
        }
        if(editor.session.getUndoManager().hasRedo()){
            let tr = body.select('.panel .redo');
            tr.removeClass('disabled');
        } else {
            let tr = body.select('.panel .redo');
            tr.addClass('disabled');
        }
    });
    let list = body.select('.panel');
    let index;
    for(index=0; index < list.length; index++){
        let panel = list[index];
        let tr_list = panel.select('tr');
        let i;
        for(i=0; i < tr_list.length; i++){
            let tr = tr_list[i];
            if(!navigator.clipboard){
                if(tr.hasClass('paste')){
                    tr.addClass('disabled');
                }
                if(tr.hasClass('copy')){
                    tr.addClass('disabled');
                }
            }
            if(tr.hasClass('undo')) {
                if(!editor.session.getUndoManager().hasUndo()){
                    tr.addClass('disabled');
                } else {
                    tr.removeClass('disabled');
                }
            }
            if(tr.hasClass('redo')) {
                if(!editor.session.getUndoManager().hasRedo()){
                    tr.addClass('disabled');
                } else {
                    tr.removeClass('disabled');
                }
            }
            tr.on('click', (event) => {
                let editor = source.get('editor.' + "{{$pre.id}}");
                if(tr.hasClass('open')){
                    console.log('open');
                    let settings = section.select('.nav-item .settings-controllers-settings');
                    console.log(settings);
                    if(settings){
                        settings.trigger('click');
                    }
                }
                if(tr.hasClass('save')){
                    source.save("card-body-{{$request.node.key}}");
                    panel.addClass('d-none');
                }
                if(tr.hasClass('save-as')){
                    source.saveAs("card-body-{{$request.node.key}}");
                    panel.addClass('d-none');
                }
                if(tr.hasClass('undo')) {
                    if(!editor.session.getUndoManager().hasUndo()){
                        tr.addClass('disabled');
                    } else {
                        editor.undo();
                        panel.addClass('d-none');
                    }
                }
                if(tr.hasClass('redo')) {
                    if(!editor.session.getUndoManager().hasRedo()){
                        tr.addClass('disabled');
                    } else {
                        editor.redo();
                        panel.addClass('d-none');
                    }
                }
                if(tr.hasClass('find')){
                    ace.config.loadModule("ace/ext/searchbox", (module) => {
                        module.Search(editor)
                    });
                        panel.addClass('d-none');
                }
                if(tr.hasClass('replace')){
                    ace.config.loadModule("ace/ext/searchbox", (module) => {
                        module.Search(editor, true)
                    });
                    panel.addClass('d-none');
                }
                if(tr.hasClass('select-all')){
                    editor.selectAll()
                    panel.addClass('d-none');
                }
                if(tr.hasClass('cut')){
                    let cutline = editor.$copyWithEmptySelection && editor.selection.isEmpty();
                    let range = cutline ? editor.selection.getLineRange() : editor.selection.getRange();
                    editor._emit('cut', range);
                    if(!range.isEmpty()){
                        editor.session.remove(range);
                    }
                    editor.clearSelection();
                    panel.addClass('d-none');
                }
                if(tr.hasClass('paste')){
                    if(navigator.clipboard){
                        navigator.clipboard.readText()
                            .then((text) => {
                                editor.$handlePaste(text);
                            })
                            .catch((err) => console.log('Async readText failed with error: "' + err + '"'));
                    } else {
                        tr.addClass('disabled');
                    }
                    panel.addClass('d-none');
                }
                if(tr.hasClass('remove-line')){
                    editor.removeLines();
                    panel.addClass('d-none');
                }
                if(tr.hasClass('duplicate')){
                    editor.duplicateSelection();
                    panel.addClass('d-none');
                }
                if(tr.hasClass('delete')){
                    editor.remove('right');
                    panel.addClass('d-none');
                }
                if(tr.hasClass('copy')){
                    let copyText = editor.getCopyText();
                    if(navigator.clipboard){
                        navigator.clipboard.writeText(copyText).then(() => {
                            /* clipboard successfully set */
                        }, () => {
                            /* clipboard write failed */
                        });
                    } else {
                        tr.addClass('disabled');
                    }
                    panel.addClass('d-none');
                }
                if(tr.hasClass('go-to-next-error')){
                    ace.config.loadModule("ace/ext/error_marker", (module) => {
                        module.showErrorMarker(editor, 1);
                    });
                    panel.addClass('d-none');
                }
                if(tr.hasClass('go-to-previous-error')){
                    ace.config.loadModule("ace/ext/error_marker", (module) => {
                        module.showErrorMarker(editor, -1);
                    });
                    panel.addClass('d-none');
                }
                event.stopPropagation();
            });

        }
    }
}

source.menu = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const body = section.select('.card-body-' + "{{$request.node.key}}");
    if(!body){
        return;
    }
    const div = body.select('.menu');
    if(!div){
        return;
    }
    div.on('click', (event) => {
        let list = body.select('.panel');
        let index;
        for(index=0; index < list.length; index++) {
            let panel = list[index];
            panel.addClass('d-none');
        }
    });
    const list = div.select('li');
    let index;
    for(index=0; index < list.length; index++){
        let li = list[index];
        li.on('click', (event) => {
            let offset = li.calculate('offset');
            let data_class = li.data('class');
            let menu = body.select('.' + data_class);
            let panel = body.select('.panel');
            let i;
            for(i=0; i < panel.length; i++){
                if(panel[i].hasClass(data_class)){
                    continue;
                }
                panel[i].addClass('d-none');
            }
            menu.css('left', offset.left + 'px');
            menu.toggleClass('d-none');
            event.stopPropagation();
        });
    }
    const pre = body.select("#{{$pre.id}}");
    if(!pre){
        return;
    }
    pre.on('click', (event) => {
        let panel = body.select('.panel');
        if(panel){
            panel.addClass('d-none');
        }
    });
    const item = section.select('.card-header-tabs li');
    if(is.nodeList(item)){
        for(index=0; index < item.length; index++){
            item[index].on('click', (event) => {
                let panel = body.select('.panel');
                if(panel){
                    panel.addClass('d-none');
                }
            });
        }
    }
    else if(item){
        item.on('click', (event) => {
            let panel = body.select('.panel');
            if(panel){
                panel.addClass('d-none');
            }

        });
    }
}

source.saveAs = (className) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const div = select('.' + className);
    if(!div){
        return;
    }
    const form = div.select('form');
    if(!form){
        return;
    }
    const dialog = form.select('.dialog-save-as');
    if(!dialog){
        return;
    }
    dialog.removeClass('d-none');
    const name = form.select('input[name="node.name"]');
    if(name){
        name.focus();
    }
}

source.save = (className) => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const div = select('.' + className);
    if(!div){
        return;
    }
    const form = div.select('form');
    if(!form){
        return;
    }
    let data = form.data('serialize');
    const pre = form.select('pre[name="node.content"]');
    if(!pre){
        return;
    }
    data.push({
        name : "node.content",
        value: pre.data('content')
    });
    const input = section.select('input[name="node.domain"]');
    if(!input){
        return;
    }
    data.push({
        name : "node.domain",
        value : input.value
    });
    request(form.data('url'), data, (url, response) => {
        if(response?.error){
            data.push({
                name: "error",
                value: response.error
            });
            request(form.data('url-error'), data, (url, response) => {

            });
        } else {
            console.log('saved...');
        }
    });
    console.log(data);
}

source.editor = () => {
    //let editor = source.get('editor.' + "{{$pre.id}}");
    let editor = false;
    if(is.empty(editor)){
        ace.require("ace/ext/language_tools");
        editor = ace.edit("{{$pre.id}}");
        editor.session.setMode("ace/mode/php");
        editor.setTheme("ace/theme/tomorrow");
        // enable autocompletion and snippets
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: true
        });
        let element = select("#{{$pre.id}}");
        element.on('keydown', function(event) {
            if ((event.ctrlKey || event.metaKey) && !event.shiftKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        source.save("card-body-{{$request.node.key}}");
                        //source.get('delete', 'editor.' + "{{$pre.id}}");
                        break;
                }
            }
            else if ((event.ctrlKey || event.metaKey) && event.shiftKey) {
                console.log('trugger');
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        source.saveAs("card-body-{{$request.node.key}}");
                        source.get('delete', 'editor.' + "{{$pre.id}}");
                        break;
                }
            }
        });
        editor.session.setValue(element.data('content'));
        editor.on('change', (e) => {
            let element = select("#{{$pre.id}}");
            element.data('content', editor.getValue());
        });
        source.set('editor.' + "{{$pre.id}}", editor);
    }
    return editor;
};

source.init = () => {
    source.editor();
    source.menu();
    source.panel();
    console.log('source init');
};

ready(() => {
require(
[
    root() + 'Settings/Controllers/Css/Source.css?' + version()
],
() => {
    source.init();
});
});