import { user } from "/Module/User.js";

let download = {};

download.init = (filename) => {
    ready(() => {
        user.data('user.token', '1234');
        if(user.token()){
            fetch('http://core.funda.local:2610/Export/', {
                'headers' : {
                    "Authorization" : "Bearer " + user.token()
                }
            })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(() => {

                });
        } else {
            console.log('redirect user.login');
        }
    });
}

export default download;