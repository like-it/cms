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
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Field/From.Name.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Field/From.Email.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Field/Host.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Field/Port.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Field/Username.tpl')}}
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Field/Password.tpl')}}
    </div>
    <div class="mb-3">
        {{require($controller.dir.view + $controller.title + '/Email/Section/Form/Button/Add.tpl')}}
    </div>
</form>