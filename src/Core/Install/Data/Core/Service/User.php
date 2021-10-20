<?php
namespace Host\Subdomain\Host\Extension\Service;


use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class User extends Main {
    const PASSWORD_ALGO = PASSWORD_BCRYPT;
    const PASSWORD_COST = 13;

    public static function create(App $object): Response
    {
        $object->request('uuid', Core::uuid());
        $object->request('node.type', 'user');
        $validate = Main::validate($object, User::getValidatorUrl($object));
        if($validate){
            if($validate->success === true){
                $url = User::getDataUrl($object);
                $dir = Dir::name($url);
                Dir::create($dir);
                $data = $object->data_read($url);
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
                $data->set($uuid . '.parameter.activation_code', User::generateActivationCode());
                $data->set($uuid . '.parameter.activation_expiration_date', strtotime('+1 day'));
                $data->write($url);
                //send activation email to user...
                //install user gets activation screen directly without email
                $record = $data->get($uuid);
                unset($record->password);
                return new Response($record, Response::TYPE_JSON);
            } else {
                return new Response($validate->test, Response::TYPE_JSON, 400);
            }
        } else {
            $error = [];
            $error['error'] = 'Validator did not received valid url...';
            return new Response($error, Response::TYPE_JSON, 400);
        }
    }

    public static function read(App $object): Response
    {
        $uuid = $object->request('uuid');
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response($error, Response::TYPE_JSON, 400);
        }
        $record = $data->get($uuid);
        if($record){
            unset($record->password);
            return new Response($record, Response::TYPE_JSON);
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: '. $uuid;
            return new Response($error, Response::TYPE_JSON, 400);
        }
    }

    public static function update(App $object){
        $object->request('node.type', 'user');
        $uuid = $object->request('uuid');
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response($error, Response::TYPE_JSON, 400);
        }
        $record = $data->get($uuid);
        if($record){
            $is_change = false;
            if($object->request('password') && $object->request('password2')){
                $validate = User::validatePasswords($object);
                if($validate->is_valid){
                    $password = password_hash($object->request('password'),User::PASSWORD_ALGO, ['cost' => User::PASSWORD_COST]);
                    $data->set($uuid . '.password', $password);
                    $is_change = true;
                } else {
                    $error = [];
                    $error['validate']['password'] = $validate->test['password'];
                    return new Response($error, Response::TYPE_JSON, 400);
                }
            }
            if($object->request('email')){
                $validate = User::validateAttribute($object, 'email');
                if($validate->is_valid){
                    $data->set($uuid . '.email', $object->request('email'));
                    $is_change = true;
                } else {
                    $error = [];
                    $error['validate']['email'] = $validate->test['email'];
                    return new Response($error, Response::TYPE_JSON, 400);
                }
            }
            if($object->request('isActive')){
                $isActive = $object->request('isActive');
                switch($isActive){
                    case 1 :
                    case '1' :
                    case 'true' :
                        $isActive = true;
                    break;
                    default:
                        $isActive = false;
                }
                $data->set($uuid . '.isActive', $isActive);
                $is_change = true;
            }
            if($is_change){
                $data->write($url);
                $record = $data->get($uuid);
                unset($record->password);
                return new Response($record, Response::TYPE_JSON);
            } else {
                $error = [];
                $error['error'] = 'Nothing has changed...';
                return new Response($error, Response::TYPE_JSON, 400);
            }
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: '. $uuid;
            return new Response($error, Response::TYPE_JSON, 400);
        }
    }

    public static function delete(App $object){
        dd('delete User');
    }

    public static function list(App $object){
        dd('list Users');
    }

    private static function getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.root') .
            'Node' .
            $object->config('ds') .
            'Validator' .
            $object->config('ds') .
            File::basename(__CLASS__) .
            $object->config('extension.json');
    }

    private static function getDataUrl(App $object): string
    {
        return $object->config('host.dir.root') .
            'Node' .
            $object->config('ds') .
            'List' .
            $object->config('ds') .
            File::basename(__CLASS__) .
            $object->config('extension.json');
    }

    private static function generateActivationCode(): string
    {
        return rand(1000, 9999) . '-' . rand(1000, 9999) . '-' .  rand(1000, 9999) . '-' .  rand(1000, 9999) . '-' .  rand(1000, 9999) . '-' .  rand(1000, 9999);
    }

    private static function validatePasswords($object)
    {
        $validate = Main::validate($object, User::getValidatorUrl($object));
        $is_valid = false;
        if($validate){
            $is_valid = true;
            foreach($validate->test['password'] as $type => $status_list){
                foreach ($status_list as $nr => $status){
                    if($status === false){
                        $is_valid = false;
                        break 2;
                    }
                }
            }
            if($is_valid){
                foreach($validate->test['password2'] as $type => $status_list){
                    foreach ($status_list as $nr => $status){
                        if($status === false){
                            $is_valid = false;
                            break 2;
                        }
                    }
                }
            }
        }
        $validate->is_valid = $is_valid;
        return $validate;
    }

    private static function validateAttribute($object, $attribute)
    {
        $validate = Main::validate($object, User::getValidatorUrl($object));
        $is_valid = false;
        if($validate){
            $is_valid = true;
            foreach($validate->test[$attribute] as $type => $status_list){
                foreach ($status_list as $nr => $status){
                    if($status === false){
                        $is_valid = false;
                        break 2;
                    }
                }
            }
        }
        $validate->is_valid = $is_valid;
        return $validate;
    }
}
