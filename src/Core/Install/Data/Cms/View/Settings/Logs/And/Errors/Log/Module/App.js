{R3M}
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";

let app = {};

app.init = () => {
    console.log('app.init');
};

ready(() => {
    require(
        [
            root() + "{{$require.module}}/{{$require.submodule}}/" + 'Css/App.css?' + version(),
        ],
        () => {
            app.init();
        });

});
