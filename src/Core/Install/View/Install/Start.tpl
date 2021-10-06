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
        body {$ldelim}
            background: rgba(0, 0, 0, 1);
            background: url('/Image/Background/4.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        {$rdelim}

        fieldset {$ldelim}
            border: 1px solid #000000;
            margin: 10px;
            padding: 10px;
        {$rdelim}

        label {$ldelim}
            display: inline-block;
            min-width: 100px;
        {$rdelim}

        .install {$ldelim}
            background: rgba(255, 255, 255, 0.5);
        {$rdelim}
    </style>
</head>
<body>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6 align-middle install">
        <form method="post" action="/Process">
            <fieldset>
                <legend>Installation</legend>
                <h1>Funda CMS</h1>
                <p>
                    Welcome to the installation... <br>
                    Before you can use Funda CMS we need some information.<br>
                </p>
                <h3>Credentials</h3>
                <label for="email">E-mail</label>
                <input id="email" name="node.email" placeholder="E-mail" /><br>
                <label for="password">Password</label>
                <input id="password" name="node.password" placeholder="Password"/>
                <h3>Domain</h3>
                <label for="domain">Host: </label>
                <input id="domain" name="node.domain" placeholder="domain name"/>
                <input name="node.extension" placeholder="domain extension"/><br>
                <br>
                <input type="submit" name="install" value="Install"/>
            </fieldset>
        </form>
    </div>
    <div class="col-3"></div>
</div>

</body>
</html>


