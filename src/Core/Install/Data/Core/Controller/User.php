<?php
namespace Host\Subdomain\Host\Extension\Controller;


use R3m\Io\App;
use R3m\Io\Module\Handler;
use R3m\Io\Module\View;
use Host\Subdomain\Host\Extension\Service\User as Service;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class User extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function command(App $object){
        $uuid = $object->request('uuid');
        $attribute = $object->request('attribute');
        if(
            $uuid &&
            $attribute
        ){
            try {
                switch(Handler::method()){
                    case Handler::GET :
                        return Service::readAttribute($object);
                    case Handler::DELETE :
                        return Service::deleteAttribute($object);
                }
            } catch (Exception $exception){
                return $exception;
            }
        } else {
            if($uuid){
                try {
                    switch(Handler::method()){
                        case Handler::GET :
                            return Service::read($object);
                        case Handler::PUT :
                            return Service::update($object);
                        case Handler::DELETE :
                            return Service::delete($object);
                    }
                } catch (Exception $exception){
                    return $exception;
                }
            } else {
                try {
                    switch(Handler::method()){
                        case Handler::GET :
                            return Service::list($object);
                        case Handler::POST :
                            return Service::create($object);
                    }
                } catch (Exception $exception){
                    return $exception;
                }
            }
        }

        /*
        $name = Index::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Index::locate($object, $name);
            return Index::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception->getMessage() . "\n";
        }
        */
    }
}
