{{R3M}}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{require($controller.dir.view + $controller.title + '/Section/Main.tpl')}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Module/Authorization.js')}}
{{/script}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Module/Navigation.js')}}
{{/script}}
