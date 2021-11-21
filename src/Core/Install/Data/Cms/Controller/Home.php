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

    public static function main(App $object){
        $name = Home::name(__FUNCTION__, __CLASS__, '/');
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = Home::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', Home::DIR);
                $view = Home::response($object, $url);
            } else {
                $url = Home::locate($object, $name);
                $view = Home::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }
}
