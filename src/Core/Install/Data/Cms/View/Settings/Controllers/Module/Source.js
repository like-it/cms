//{{R3M}}
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
import { getSectionByName } from "/Module/Section.js";
import { contains, replace } from "/Module/String.js";

source.init = () => {
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
};

ready(() => {
require(
[
    root() + 'Ace/1.4.14/src/ace.js?' + version(),
    root() + 'Ace/1.4.14/src/ext-language_tools.js?' + version(),
    root() + 'Settings/Controllers/Css/Source.css?' + version()
],
() => {
    source.init();
});
});