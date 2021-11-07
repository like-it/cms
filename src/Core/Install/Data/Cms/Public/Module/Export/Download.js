import { user } from "/Module/User.js";

let download = {};

download.init = () => {
    request('http://core.funda.local/Export/');
}

export { download }