{data.read(config('project.dir.data') + 'Config.json')}
{d(config('version'))}
{dd($version)}
<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Remco van der Velde info@universeorange.com"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Funda | Import</title>
    <meta name="revisit-after" content="7 days" />
    <meta name="rating" content="general" />
    <meta name="distribution" content="global" />
    <meta name="keywords" content="funda, cms, import">
    <meta name="description" content="Funda CMS Import">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="stylesheet" href="https://universeorange.com/font-awesome-5.14.0/css/all.css?0.0.1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&display=swap" rel="stylesheet">
    <script src="http://script.universeorange.local:2603/Js/Priya/Priya.js"></script>
    <script src="/Dropzone/5.9.2/min/dropzone.min.js?1.0.0"></script>
    <link rel="stylesheet" href="/Dropzone/5.9.2/min/dropzone.min.css?1.0.0">
    <script type="module">
        fetch('http://core.funda.local:2610/Export/')
            .then(resp => resp.blob())
            .then(blob => {$ldelim}
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // the filename you want
                a.download = "funda-{$version}.zip";
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            {$rdelim})
            .catch(() => {$ldelim}

            {$rdelim});
    </script>
    </head>
<body>
Dropzone
</body>
</html>