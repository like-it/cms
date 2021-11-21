{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
{{script('module')}}
{{require($controller.dir.view + $controller.title + '/Module/Authorization.js')}}
{{/script}}
{{dd($controller)}}
{{require($controller.dir.view + $controller.title + '/Section/Main.tpl')}}
