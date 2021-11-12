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

user.refreshToken = () => {
    return _('user').collection('user.refresh.token');
}

user.token = () => {
    return _('user').collection('user.token');
}

export default user;