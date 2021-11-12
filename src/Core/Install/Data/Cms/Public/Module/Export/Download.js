let download = {};

download.init = (config) => {
    fetch(config.url, {
        'headers' : {
            "Authorization" : "Bearer " + config.token
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = config.filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(() => {

    });
}

export default download;