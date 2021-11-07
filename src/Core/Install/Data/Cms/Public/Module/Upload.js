import { user } from "/Module/User.js";

let upload = {};

upload.init = () => {
    const body = select('body');
    if(!body){
        return;
    }
    let upload = body.select('.upload');
    let token = user.token();
    if(!upload) {
        upload = priya.create('div', 'dropzone upload');
        upload.attribute('id', 'upload');
        upload.data('url', 'http://core.funda.local:2610/Import/');
        upload.data('upload-max-filesize', '1024 M');
        body.appendChild(upload);
        console.log(token);
        if(token){
            let drop = new Dropzone(
                '#' + upload.attribute('id'), {
                    url: upload.data('url'),
                    maxFilesize: upload.data('upload-max-filesize'),
                    headers: {
                        "Authorization": "Bearer " + token
                    }
                }
            );
            drop.on("sending", function (file, xhr, formData) {
                //xhr.setRequestHeader('Authorization', 'Bearer ' + user.token());
                /*
                exception.authorization(() => {

                });
                 */
            });
            drop.on("complete", function (file) {
                console.log('start unpacking...');
                console.log(file);
                /*
                const refresh = section.select('.refresh');
                if (!refresh) {
                    return;
                }
                refresh.trigger('click');
                 */
            });
        }

    }
}

export { upload }