{R3M}
{{require($controller.dir.view + $controller.title + '/Init.tpl')}}
<form
    name="settings-email-settings-form"
    method="post"
    data-url="{{server.url('core')}}Settings/Email/Add/"
    data-url-error="{{route.get(route.prefix() + '-settings-email-add-body')}}"
>
    {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Error.tpl')}}
    <div class="mb-3">
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Field/From.Name.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Field/From.Email.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Field/Host.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Field/Port.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Field/Username.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Field/Password.tpl')}}
    </div>
    <div class="mb-3">
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Component/Button/Add.tpl')}}
    </div>
</form>