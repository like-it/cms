//{{R3M}}
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";
import { contains, replace } from "/Module/String.js";

(function(window){
    window.htmlentities = {
        /**
         * Converts a string to its html characters completely.
         *
         * @param {String} str String with unescaped HTML characters
         **/
        encode : function(str) {
            var buf = [];

            for (var i=str.length-1;i>=0;i--) {
                buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
            }

            return buf.join('');
        },
        /**
         * Converts an html characterSet into its original character.
         *
         * @param {String} str htmlSet entities
         **/
        decode : function(str) {
            return str.replace(/&#(\d+);/g, function(match, dec) {
                return String.fromCharCode(dec);
            });
        }
    };
})(window);

let source = {};

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
        let li = panel.select('li')
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
    ace.require("ace/ext/language_tools");
    let editor = ace.edit("{{$pre.id}}");
    editor.session.setMode("ace/mode/php");
    editor.setTheme("ace/theme/tomorrow");
    // enable autocompletion and snippets
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true
    });
    let element = select('#' + "{{$pre.id}}");
    element.env.editor.session.setValue(element.data('content'));

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