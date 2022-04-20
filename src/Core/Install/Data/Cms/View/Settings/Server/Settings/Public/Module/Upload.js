let upload = {};

upload.init = ({
    url,
    token,
    upload_max_filesize,
    target,
    section,
    message,
    form
}) => {
    let body;
    if(is.empty(target)){
        body = select('body');
    } else if(typeof target === 'string'){
        body = select(target);
    }
    else {
        body = target;
    }
    if(!body){
        return;
    }
    let input = select('.dz-hidden-input');
    if(input){
        input.remove();
    }
    let upload = body.select('.upload');
    if(!upload) {
        upload = priya.create('div', 'dropzone upload');
        upload.attribute('id', 'upload');
        upload.data('url', url);
        upload.data('upload-max-filesize', upload_max_filesize);
        body.appendChild(upload);
        if(token){
            let drop = new Dropzone(
                '#' + upload.attribute('id'), {
                    url: upload.data('url'),
                    maxFilesize: upload.data('upload-max-filesize'),
                    filesizeBase: 1024,
                    dictDefaultMessage: message,
                    headers: {
                        "Authorization": "Bearer " + token
                    }
                }
            );
            drop.on("sending", function (file, xhr, formData) {
                let data = form.data('serialize') ?? [];
                let index;
                for(index=0;index< data.length; index++){
                    let item = data[index];
                    formData.append(item.name, item.value);
                }
            });
            drop.on("complete", function (file) {

            });
        }
    }
}

export default upload;