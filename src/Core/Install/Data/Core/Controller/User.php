<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Module\Handler;
use R3m\Io\Module\View;
use R3m\Io\Module\Response;
use Host\Subdomain\Host\Extension\Service\User as Service;
use Host\Subdomain\Host\Extension\Service\Host;

use Exception;

class User extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;
    const NAME = 'User';

    const COMMAND_INFO = 'info';
    const COMMAND_TOKEN = 'token';
    const COMMAND = [
        User::COMMAND_INFO,
        User::COMMAND_TOKEN,
    ];
    const DEFAULT_COMMAND = User::COMMAND_INFO;

    const EXCEPTION_COMMAND_PARAMETER = '{$command}';
    const EXCEPTION_COMMAND = 'invalid command (' . System::EXCEPTION_COMMAND_PARAMETER . ')' . PHP_EOL;

    const INFO = [
        '{binary()} user token <email>             | Request a login token with e-mail',
    ];

    /**
     * @throws Exception
     */
    public static function command(App $object)
    {
        if(Handler::method() === Handler::METHOD_CLI){
            $command = $object->parameter($object, User::NAME, 1);
            if($command === null){
                $command = User::DEFAULT_COMMAND;
            }
            if(!in_array($command, User::COMMAND)){
                $exception = str_replace(
                    User::EXCEPTION_COMMAND_PARAMETER,
                    $command,
                    User::EXCEPTION_COMMAND
                );
                throw new Exception($exception);
            }
            Host::dir_root($object);
            $object->request('email', App::parameter($object, $command, 1));
            return User::{$command}($object);
            /*
            $command = App::parameter($object, 'user', 1);
            switch($command){
                case 'token' :
                    $object->config('host.dir.root', Host::dir_root($object));
                    $object->request('email', App::parameter($object, $command, 1));
                    return Service::token($object);
                default:
                    throw new Exception('Invalid command.');
            }
            */
        } else {
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
    }

    public static function login(App $object)
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

    public static function current(App $object)
    {
        try {
            return Service::current($object);
        } catch (AuthorizationException $exception){
            return $exception;
        }

    }

    public static function token(App $object){
        try {
            return Service::token($object);
        } catch (Exception | AuthorizationException $exception){
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
