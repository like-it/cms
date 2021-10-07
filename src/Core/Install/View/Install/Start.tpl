{require($controller.dir.view + $controller.title + '/Init.tpl')}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="author" content="{$html.head.author|default:''}">
    <meta http-equiv="content-type" content="{$html.head.content.type | default:'text/html; charset=UTF-8'}">
    <meta http-equiv="X-UA-Compatible" content="{$html.head.compatible|default:'IE=edge,chrome=1'}">
    <meta name="viewport" content="{$html.head.viewport|default:'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'}">
    <title>Funda CMS | Installation</title>
    <meta name="revisit-after" content="{$html.head.revisit|default:'7 days'}">
    <meta name="rating" content="{$html.head.rating|default:'general'}">
    <meta name="distribution" content="{$html.head.distribution|default:'global'}">
    <meta name="keywords" content="{$html.head.keywords}">
    <meta name="description" content="{$html.head.description|default:''}">
    <link rel="shortcut icon" href="{$html.head.icon|default:''}">
    <link rel="stylesheet" href="/Bootstrap/5.1.0/css/bootstrap.css">
    <style>
        html, body {$ldelim}
            height: 100%;
            width: 100%;
        {$rdelim}
        body {$ldelim}
            background: rgba(0, 0, 0, 1);
            background: url('/Image/Background/1.jpg');
            background-repeat: repeat-y;
            background-size: cover;
        {$rdelim}

        fieldset {$ldelim}
            border: 1px solid #000000;
            border-radius: 0.75rem;
            padding: 10px;
        {$rdelim}

        label {$ldelim}
            display: inline-block;
            min-width: 8rem;
        {$rdelim}

        .install {$ldelim}
            background: rgba(255, 255, 255, 0.75);
            background: rgba(100, 177, 248, 0.5);
            border-radius: 0.75rem;
        {$rdelim}
    </style>
</head>
<body>
<div class="row h-100 w-100">
    <div class="col-3"></div>
    <div class="col-6 align-self-center shadow p-3 mb-5 rounded install">
        <form method="post" action="/Installation/Process">
            <fieldset>
                <legend>{__('install.legend')}</legend>
                <h1>{__('install.title')}</h1>
                <p>
                    {__('install.text')}
                </p>
                <h3>{__('install.credentials.title')}</h3>
                <p>
                    {__('install.credentials.text')}
                </p>
                {if($error.test.email.validate_is_email.0 === false)}
                    <p class="alert alert-danger" role="alert">
                        The e-mail address is invalid.
                    </p>
                {/if}
                <label for="email">{__('install.email.label')}</label>
                <input id="email" name="node.email" placeholder="{__('install.email.placeholder')}" value="{$request.node.email}"/><br>
                <label for="password">{__('install.password.label')}</label>
                <input id="password" type="password" name="node.password" placeholder="{__('install.password.placeholder')}"/><br>
                <label for="password-again">{__('install.password.again.label')}</label>
                <input id="password-again" type="password" name="node.password2" placeholder="{__('install.password.again.placeholder')}"/><br>
                <h3>{__('install.domain.title')}</h3>
                <p>
                    {__('install.domain.text')}
                </p>
                <label for="domain">{__('install.domain.label')}</label>
                <input id="domain" name="node.domain" placeholder="{__('install.domain.placeholder')}" value="{$request.node.domain}"/><br>
                <input type="submit" name="install" value="{__('install.button.submit')}"/><br>
            </fieldset>
        </form>
    </div>
    <div class="col-3"></div>
</div>

</body>
</html>


