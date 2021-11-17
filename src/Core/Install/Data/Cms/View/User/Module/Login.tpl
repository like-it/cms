{R3M}
{{script('module')}}
import user from "/Module/User.js";
import { version } from "/Module/Priya.js";
import { root } from "/Module/Web.js";
ready(() => {
    require(
    [
    root() + 'User/Css/Login.css?' + version(),
    root() + 'User/Css/Password.Forgot.css?' + version(),
    root() + 'Debug/Css/Debug.css?' + version(),
    root() + 'Index/Css/Start.css?' + version(),
    ],
    () => {
        console.log('user login');
    });
});
{{/script}}