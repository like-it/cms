<?php
namespace LikeIt\Cms\Core\Install\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Zip extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;

    const INFO = [
        '{{binary()}} zip <source> <destination>     | Create zip file'
    ];

    public static function cli(App $object){
        dd($object->request());
        $name = Zip::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Zip::locate($object, $name);
            $view = Zip::response($object, $url);
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }
}
