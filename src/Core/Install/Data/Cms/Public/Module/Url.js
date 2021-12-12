let url = {};

url.encode = (string) => {
    return encodeURIComponent(string).replace(/[!'()*]/g, function(c) {
        return '%' + c.charCodeAt(0).toString(16);
    });
}

export default url;