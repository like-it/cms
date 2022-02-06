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
        console.log(row);





        content += row;
    }

    return rows;
};

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

    rows = source.compile(rows);
    let index;
    for(index=0; index < rows.length; index++){
        let row = rows[index];
        let li = create('li');
        li.data('nr', index + 1);
        let pre = create('pre');
        pre.html(row);
        li.append(pre);
        ol.append(li);
    }
};

source.init = () => {
    source.createLi();
};

ready(() => {
    require(
        [
            root() + 'He/1.2.0/he.js?' + version(),
            root() + 'Settings/Controllers/Css/Source.css?' + version()
        ],
        () => {
            source.init();
        });
});