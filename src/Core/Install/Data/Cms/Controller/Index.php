<?php
namespace Host\Cms\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Index extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function overview(App $object){
        $name = Index::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Index::locate($object, $name);
            return Index::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception->getMessage() . "\n";
        }
    }
}
