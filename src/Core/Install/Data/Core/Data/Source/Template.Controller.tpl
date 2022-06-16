{{R3M}}
{{$namespace.subdomain = $domain.subdomain|uppercase.first}}
{{$namespace.host = $domain.host|uppercase.first}}
{{$namespace.extension = $domain.extension|uppercase.first}}
{{if(!is.empty($namespace.subdomain))}}
{{$namespace.php = 'Host\\' + $namespace.subdomain + '\\' + $namespace.host + '\\' + $namespace.extension + '\\Controller'}}
{{else}}
{{$namespace.php = 'Host\\' + $namespace.host + '\\' + $namespace.extension + '\\Controller'}}
{{/if}}
{{$node = request('node')}}
{{$use = [
'R3m\Io\App',
'R3m\Io\Module\View',
'Exception',
'R3m\Io\Exception\LocateException',
'R3m\Io\Exception\UrlEmptyException',
'R3m\Io\Exception\UrlNotExistException',
]}}
<?php
namespace {{$namespace.php}};

{{for.each($use as $usage)}}
use {{$usage}};
{{/for.each}}

class {{$node.name|uppercase.first}} extends View {

    const DIR = __DIR__ . DIRECTORY_SEPARATOR;

}
    