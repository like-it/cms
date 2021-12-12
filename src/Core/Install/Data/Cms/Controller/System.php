<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class System extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function main(App $object){
        $name = System::name(__FUNCTION__, __CLASS__, '/');
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = System::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', System::DIR);
                $view = System::response($object, $url);
            } else {
                $url = System::locate($object, $name);
                $view = System::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function body(App $object){
        $name = System::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = System::locate($object, $name);
            return System::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function information(App $object){
        $name = System::name(__FUNCTION__, __CLASS__, '/');
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = System::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', System::DIR);
                $view = System::response($object, $url);
            } else {
                $url = System::locate($object, $name);
                $view = System::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function information_body(App $object){
        $name = System::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            $url = System::locate($object, $name);
            return System::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function update_body(App $object){
        $name = System::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            $url = System::locate($object, $name);
            return System::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function update_cms(App $object){
        $name = System::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            $url = System::locate($object, $name);
            return System::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

}
