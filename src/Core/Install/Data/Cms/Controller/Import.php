<?php
namespace Host\Subdomain\Host\Extension\Controller;


use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Import extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;

    public static function main(App $object){
        $name = Import::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Import::locate($object, $name);
            return Import::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }
}
