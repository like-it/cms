<?php
namespace LikeIt\Cms\Cli\Install;

$dir = __DIR__;
$dir_vendor =
    dirname($dir, 1) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR;

var_dump($dir_vendor);
die;

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