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
                    }
                }
                if(tr.hasClass('redo')) {
                    if(!editor.session.getUndoManager().hasRedo()){
                        tr.addClass('disabled');
                    } else {
                        editor.redo();
                    }
                }
                if(tr.hasClass('find')){
                    console.log(editor.searchBox);
                    if(!editor.searchBox){
                        ace.require("ace/ext/searchbox");
                        // editor.Search(editor, true);
                    }
                    /*
                    if (!editor.searchBox) {
                        config.loadModule("ace/ext/searchbox", function(e) {
                            e.Search(editor, true);
                        });
                    } else {
                        if (editor.searchBox.active === true && editor.searchBox.replaceOption.checked === true) {
                            editor.searchBox.replaceAll();
                        }
                    }
                     */
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