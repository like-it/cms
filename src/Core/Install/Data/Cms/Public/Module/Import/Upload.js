let upload = {};

upload.init = (config) => {
    const body = select('body');
    if(!body){
        return;
    }
    let upload = body.select('.upload');
    let token = config.token;
    if(!upload) {
        upload = priya.create('div', 'dropzone upload');
        upload.attribute('id', 'upload');
        upload.data('url', config.url);
        upload.data('upload-max-filesize', config.upload_max_filesize);
        body.appendChild(upload);
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

export default upload;