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
    let list = body.select('.panel');
    let index;
    for(index=0; index < list.length; index++){
        let panel = list[index];
        let tr_list = panel.select('tr');
        let i;
        for(i=0; i < tr_list.length; i++){
            let tr = tr_list[i];
            tr.on('click', (event) => {
                let editor = source.get('editor.' + "{{$pre.id}}");
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
                    editor.$handlePaste();
                    panel.addClass('d-none');
                }
                if(tr.hasClass('remove-line')){
                    editor.removeLines();
                    panel.addClass('d-none');
                }
                if(tr.hasClass('duplicate')){
                    editor.duplicatteSelection();
                    panel.addClass('d-none');
                }
                if(tr.hasClass('delete')){
                    editor.remove('right');
                    panel.addClass('d-none');
                }
                if(tr.hasClass('copy')){
                    let copyText = editor.getCopyText();
                    navigator.clipboard.writeText(copyText).then(function(){
                        console.log("The text has been succesfully copied to the clipboard!");
                    });
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
    const ul = body.select('.menu');
    if(!ul){
        return;
    }
    const list = ul.select('li');
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
        });
    }
    const pre = body.select("#{{$pre.id}}");
    if(!pre){
        return;
    }
    pre.on('click', (event) => {
        let panel = body.select('.panel');
        panel.addClass('d-none');
    });
    const item = section.select('.card-header-tabs li');
    if(is.nodeList(item)){
        for(index=0; index < item.length; index++){
            item[index].on('click', (event) => {
                let panel = body.select('.panel');
                panel.addClass('d-none');
            });
        }
    }
    else if(item){
        item.on('click', (event) => {
            let panel = body.select('.panel');
            panel.addClass('d-none');
        });
    }
}

source.editor = () => {
    let editor = source.get('editor.' + "{{$pre.id}}");
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
        let element = select('#' + "{{$pre.id}}");
        editor.session.setValue(element.data('content'));
        //element.env.editor.session.setValue(element.data('content'));
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