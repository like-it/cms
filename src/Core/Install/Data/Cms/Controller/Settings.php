<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Settings extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function main(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = Settings::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', Settings::DIR);
                $view = Settings::response($object, $url);
            } else {
                $url = Settings::locate($object, $name);
                $view = Settings::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function export(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function export_settings(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }
}
