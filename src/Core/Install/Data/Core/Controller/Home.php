<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Home extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function body(App $object){
        $name = Home::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Home::locate($object, $name);
            return Home::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }
}
