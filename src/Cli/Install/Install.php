<?php
namespace LikeIt\Cms\Cli\Install;

use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
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
    $output = [];
    $command = 'funda configure public create Public';
    Core::execute($command, $output);
    echo implode(PHP_EOL, $output);
    echo PHP_EOL;
    $source = $dir . $app->config('ds') . 'Data' . $app->config('ds') . '1.jpg';
    $destination_dir = $app->config('project.dir.public') . 'Image' . $app->config('ds') . 'Background' . $app->config('ds');
    Dir::create($destination_dir);
    $destination_url = $destination_dir . '1.jpg';
    File::copy($source, $destination_url);
    $output = [];
    $command = 'chown www-data:www-data ' . $app->config('project.dir.public') . ' -R';
    Core::execute($command, $output);
}


$route_url = $app->config('project.dir.data') . 'Route.json';

if(!File::exist($route_url)){
    $output = [];
    $command = 'funda configure route resource "{\$project.dir.vendor}like-it/cms/Data/Route.json"';
    Core::execute($command, $output);
    echo implode(PHP_EOL, $output);
    $output = [];
    $command = 'chown www-data:www-data ' . $route_url;
    Core::execute($command, $output);
    echo implode(PHP_EOL, $output);
    echo PHP_EOL;
}
exit();