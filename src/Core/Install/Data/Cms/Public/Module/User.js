import login from "../User/Module/Login";

let user = {};

user.get = (attribute) => {
    return _('user').collection(attribute);
}

user.set = (attribute, value) => {
    _('user').collection(attribute, value);
}

user.data = (data) => {
    if(data){
        _('user').collection(data);
    } else {
        return _('user').collection();
    }
}

user.refreshToken = (refreshToken) => {
    if(refreshToken){
        localStorage.setItem('refreshToken', refreshToken);
    } else {
        return localStorage.getItem('refreshToken')
    }
}

user.token = (token) => {
    if(token){
        localStorage.setItem('token', token);
    } else {
        return localStorage.getItem('token')
    }
}

export default user;