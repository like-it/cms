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
$config = new R3m\Io\Config(
    [
        'dir.vendor' => $dir_vendor
    ]
);
$app = new R3m\Io\App($autoload, $config);
if(!File::exist($app->config('project.dir.data')) . 'Route.json'){
    echo 'create route...';
}