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
            console.log(li);
            let data_class = li.data('class');
            let menu = select('.' + data_class);
            menu.toggleClass('d-none');
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