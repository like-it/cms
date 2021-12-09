<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Module\Handler;
use R3m\Io\Module\View;
use R3m\Io\Module\Response;
use Host\Subdomain\Host\Extension\Service\User as Service;

use Exception;

class User extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function command(App $object): Exception|Response
    {
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
                            if(stristr($object->request('request'), 'user/current') !== false){
                                return Service::current($object);
                            } else {
                                return Service::create($object);
                            }

                    }
                } catch (Exception $exception){
                    return $exception;
                }
            }
        }
    }

    public static function login(App $object): Exception|Response
    {
        try {
            $is_blocked = Service::is_blocked($object);
            if($is_blocked){
                throw new Exception('User is blocked for 15 minutes...', Service::EXCEPTION_BLOCKED);
            }
            return Service::login($object);
        }
        catch (Exception $exception){
            return $exception;
        }
    }

    public static function current(App $object): Exception|AuthorizationException|Response
    {
        try {
            return Service::current($object);
        } catch (AuthorizationException $exception){
            return $exception;
        }

    }

    public static function refresh_token(App $object){
        try {
            return Service::refresh_token($object);
        } catch (Exception | AuthorizationException $exception){
            return $exception;
        }
    }
}
