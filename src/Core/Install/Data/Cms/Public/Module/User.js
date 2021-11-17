let user = {};

user.get = () => {
    return _('user').collection();
}

user.set = (data) => {
    _('user').collection('user', data);
}

user.data = (attribute, value) => {
    return _('user').collection(attribute, value);
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

user.login = () => {
    console.log('user.login')
}

export default user;