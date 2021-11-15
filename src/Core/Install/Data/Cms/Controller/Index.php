<?php
namespace Host\Subdomain\Host\Extension\Controller;

use Host\Admin\Universeorange\Com\Controller\User;
use R3m\Io\App;
use R3m\Io\Module\View;

use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Index extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function main(App $object){
        dd($object->config());
        $name = Index::name(__FUNCTION__, __CLASS__, '/');
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = Index::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', Index::DIR);
                $view = Index::response($object, $url);
            } else {
                $url = Index::locate($object, $name);
                $view = Index::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function overview(App $object){
        $name = Index::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Index::locate($object, $name);
            return Index::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }
}
