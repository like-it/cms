import user from "/Module/User.js";

let login = {};

login.get = (attribute) => {
    return _('login').collection(attribute);
}

login.set = (attribute, value) => {
    _('login').collection(attribute, value);
}

login.data = (data) => {
    if(data){
        _('login').collection(data);
    } else {
        return _('login').collection();
    }
}

login.init = (data) => {
    login.data(data);
    login.form();
    login.forgot();
    login.focus();
}

login.forgot = () => {
    const forgot = select('button.password-forgot');
    if(forgot){
        forgot.on('click', function(event){
            forgot.request();
        });
    }
}

login.focus = () => {
    const email = select('input[name="email"]');
    if(email){
        email.focus();
    }
}

login.loader = (type) => {
    switch (type){
        case 'start' :
            const submit = select('button[type="submit"]');
            submit.html(submit.html() + '<i class="fas fa-spinner fa-spin"></i>');
            break;
        case 'end' :
            const load = select('button[type="submit"] i');
            load.remove();
            break;
    }
}

login.form = () => {
    const form = select('form[name="user_login"]');
    if(form) {
        form.on('submit', (event) => {
            event.preventDefault();
            login.post(event);
        });
    }
}

login.post = (event) => {
    const form = event.target.closest('form');
    const data = form.data('serialize');
    //loading
    login.loader('start');
    form.request(data, null, (url, response) => {
        //end loading
        login.loader('end');
        if(
            !is.empty(response.class) &&
            response.class === 'Exception'
        ){
            if(!is.empty(response.code)){
                const code = response.code;
                switch(code){
                    case 400 :
                        const route_blocked = login.get('route.frontend.blocked');
                        if(route_blocked){
                            setTimeout(function(){
                                request(route_blocked);
                            }, 1000);
                        }
                        break;
                }
            }
            const error = form.select('.user-login-error');
            if(error){
                error.html(response.message);
            }
        }
        else if(!is.empty(response.user)){
            const error = form.select('.user-login-error');
            if(error){
                error.html('');
            }
            const route_success = login.get('route.frontend.start');
            localStorage.setItem('token', response.user?.token);
            localStorage.setItem('refreshToken', response.user?.refreshToken);
            const node = response.user;
            delete node.token;
            delete node.refreshToken;
            user.data(node);
            if(route_success){
                window.history.pushState(route_success, route_success, route_success);
                request(route_success, response);
            }
        }
    });
}

export default login;