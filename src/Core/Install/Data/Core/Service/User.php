<?php
namespace Host\Subdomain\Host\Extension\Service;


use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class User extends Main {
    const PASSWORD_ALGO = PASSWORD_BCRYPT;
    const PASSWORD_COST = 13;

    public static function create(App $object){
        $object->request('uuid', Core::uuid());
        $object->request('node.type', 'user');
        $validate = Main::validate($object, User::getValidatorUrl($object));
        if($validate){
            if($validate->success === true){
                $data = $object->data_read(User::getDataUrl($object));
                if(!$data){
                    $data = new Data();
                }
                $uuid = $object->request('uuid');
                $password = password_hash($object->request('password'),User::PASSWORD_ALGO, ['cost' => User::PASSWORD_COST]);
                $email = $object->request('email');
                $data->set($uuid . '.uuid', $uuid);
                $data->set($uuid . '.email', $email);
                $data->set($uuid . '.password', $password);
                $data->set($uuid . '.isActive', false);
                $data->write(User::getDataUrl($object));
                //store activation code in userParameter with activation expiration date...
                //send activation email to user...
                return new Response($data->get($uuid), Response::TYPE_JSON);
            } else {
                return new Response($validate->test, Response::TYPE_JSON, 400);
            }
        } else {
            $error = [];
            $error['error'] = 'Validator did not received valid url...';
            return new Response($error, Response::TYPE_JSON, 400);
        }
    }

    public static function read(App $object){
        dd('read User');
    }

    public static function update(App $object){
        dd('update User');
    }

    public static function delete(App $object){
        dd('delete User');
    }

    public static function list(App $object){
        dd('list Users');
    }

    private static function getValidatorUrl(App $object){
        $url = $object->config('host.dir.root') .
            'Node' .
            $object->config('ds') .
            'Validator' .
            $object->config('ds') .
            File::basename(__CLASS__) .
            $object->config('extension.json');
        return $url;
    }

    private static function getDataUrl(App $object){
        $url = $object->config('host.dir.root') .
            'Node' .
            $object->config('ds') .
            'List' .
            $object->config('ds') .
            File::basename(__CLASS__) .
            $object->config('extension.json');
        return $url;
    }

}
