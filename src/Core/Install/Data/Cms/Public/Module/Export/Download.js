import { user } from "/Module/User.js";

let download = {};

download.init = () => {
    request('http://core.funda.local:2610/Export/');
}

export { download }