let logout = {};

logout.close = () => {
    localStorage.setItem('token', null);
    localStorage.setItem('refreshToken', null);
    redirect('/');
}

logout.init = (data) => {
    logout.close();

}

export default logout;