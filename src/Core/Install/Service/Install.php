<?php
namespace LikeIt\Cms\Core\Install\Service;

use JetBrains\PhpStorm\NoReturn;
use R3m\Io\App;

use Exception;

class Install {

    public static function start(App $object){
        dd($object->request());
    }
}
