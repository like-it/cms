let upload = {};

upload.init = (config) => {
    let body;
    if(is.empty(config.target)){
        body = select('body');
    } else {
        body = select(config.target);
    }
    if(!body){
        return;
    }
    let input = select('.dz-hidden-input');
    console.log('input', input);
    if(input){
        input.remove();
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

            });
            drop.on("complete", function (file) {

            });
        }
    }
}

export default upload;