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
</head>
<body>
<form method="post" action="/Process">
    <h1>Funda CMS</h1>
    <h3>Installation:</h3>
    <fieldset>
        <legend>Admin User:</legend>
        <label for="email">E-mail</label>
        <input id="email" name="node.email" placeholder="E-mail" />
        <label for="password">Password</label>
        <input id="password" name="node.password" placeholder="Password"/>
    </fieldset>
    <fieldset>
        <legend>Cms location:</legend>
        <label for="cms-subdomain">Cms host: </label>
        <input id="cms-subdomain" name="node.cms.subdomain" disabled value="cms" />
        <input name="node.cms.domain" placeholder="domain name"/>
        <input name="node.cms.extension" placeholder="domain extension"/>
    </fieldset>
    <fieldset>
        <legend>Core location:</legend>
        <label for="core-subdomain">Core host: </label>
        <input id="core-subdomain" name="node.core.subdomain" disabled value="core" />
        <input name="node.core.domain" placeholder="domain name"/>
        <input name="node.core.extension" placeholder="domain extension" />
    </fieldset>
</form>
</body>
</html>


