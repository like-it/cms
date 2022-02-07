//{{R3M}}
import create from "/Module/Create.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";
import { contains, replace } from "/Module/String.js";
import { php } from "/Source/Module/Source.js";

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

source.compile = (rows) => {
    let index;
    let content = '';
    for(index = 0; index < rows.length; index++){
        let row = rows[index];
        row = htmlentities.encode(row);
        let i;
        for(i =0; i < php.replace.length; i++){
            let record = php.replace[i];
            row = replace(htmlentities.encode(record.search), record.replace, row);
        }
        if(is.empty(row)){
            row = '&ZeroWidthSpace;'
        }
        console.log(row);
        rows[index] = row;
        content += row;
    }

    return rows;
};

source.getAnchorPosition = () => {
    let position = 0;
    let selection;
    let range;
    selection = window.getSelection();
    if (selection.rangeCount) {
        range = selection.getRangeAt(0);
        position = range.startOffset;
    }
    return position;
}

source.createLi = () => {
    const section = getSectionByName('main-content');
    if(!section){
        return;
    }
    const ol = section.select('.' + "{{$ol.class}}");
    if(!ol){
        return;
    }
    const content = ol.data('content');
    if(!content){
        //init empty content line
        return;
    }
    let rows = content.split("\n");
    let compile = source.compile(rows);
    let index;
    ol.html('');
    for(index=0; index < rows.length; index++){
        let row = rows[index];
        let compiled_row = compile[index];
        let li = create('li');
        li.data('nr', index + 1);
        let pre = create('pre');
        pre.html(compiled_row);
        pre.data('text', pre.innerText);
        //pre.data('compile', compiled_row);
        li.append(pre);
        ol.append(li);
    }
    ol.on('keypress', (event) => {
        //if arrow down
        //selected = index;
        console.log(event);
        let li = ol.select('li');
        let index;
        let node;
        let pre;
        let selected;
        let selected_pre;
        rows = [];
        for(index = 0; index < li.length; index++){
            node = li[index];
            pre = node.select('pre');
            console.log(pre.innerText);
            if(pre.data('text') !== pre.innerText){
                selected = index;
                selected_pre = pre;
            }
            pre.data('text', pre.innerText);
            //pre.data('compile', pre.innerText);
            rows[index] = pre.data('text');
        }
        console.log(selected);
        console.log(selected_pre);
    });
};

source.init = () => {
    source.createLi();
};

ready(() => {
    require(
        [
            // root() + 'Rangy/1.3.0/rangy-core.js?' + version(),
            // root() + 'Rangy/1.3.0/rangy-selectionsaverestore.js?' + version(),
            root() + 'Settings/Controllers/Css/Source.css?' + version()
        ],
        () => {
            source.init();
        });
});