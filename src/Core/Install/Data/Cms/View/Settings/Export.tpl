{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{dd($request)}}
/*
if(user.token()){
download.init({
url: "{{server.url('core')}}Export/",
filename: "funda-{{config('version')}}.zip",
token: user.token(),
});
} else {
redirect("{{server.url('cms')}}User/Login/")
}


*/