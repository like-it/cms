<?php
namespace LikeIt\Cms\Cli\Install;

use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\File;

$dir = __DIR__;
$dir_vendor =
    dirname($dir, 5) .
    DIRECTORY_SEPARATOR;

if(!is_dir($dir_vendor)){
    echo 'Please start bash in the CLI...';
    return;
}

$autoload = $dir_vendor . 'autoload.php';
$autoload = require $autoload;
$config = new Config(
    [
        'dir.vendor' => $dir_vendor
    ]
);
$app = new App($autoload, $config);

$index_url = $app->config('project.dir.public') . 'index.php';
if(!File::exist($index_url)){
    echo 'create index...';
}

$route_url = $app->config('project.dir.data') . 'Route.json';

if(!File::exist($route_url)){
    echo 'create route...';
}