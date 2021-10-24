<?php
namespace Host\Subdomain\Host\Extension\Service;


use R3m\Io\App;
use R3m\Io\Exception\ObjectException;
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

    const REQUEST_DONT_UPDATE = [
        'request',
        'password',
        'password2',
        'uuid',
    ];

    const REQUEST_DONT_EXPOSE = [
        'password'
    ];

    public static function create(App $object): Response
    {
        $object->request('uuid', Core::uuid());
        $validate = Main::validate($object, User::getValidatorUrl($object), 'user');
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
                return new Response(
                    $record,
                    Response::TYPE_JSON
                );
            } else {
                return new Response(
                    $validate->test,
                    Response::TYPE_JSON,
                    Response::STATUS_ERROR
                );
            }
        } else {
            $error = [];
            $error['error'] = 'Validator did not received valid url...';
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
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
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $record = $data->get($uuid);
        if($record){
            unset($record->password);
            return new Response(
                $record,
                Response::TYPE_JSON
            );
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: '. $uuid;
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
    }

    public static function update(App $object): Response
    {

        $uuid = $object->request('uuid');
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $record = $data->get($uuid);
        if($record){
            $is_change = false;
            foreach($object->request() as $key => $value){
                if(in_array($key, User::REQUEST_DONT_UPDATE)){
                    continue;
                }
                $value = User::getValue($value);
                $validate = User::validateAttribute($object, $key);
                if($validate->is_valid){
                    $data->set($uuid . '.' . $key, $value);
                    $is_change = true;
                } else {
                    $error = [];
                    $error['validate'][$key] = $validate->test[$key];
                    return new Response(
                        $error,
                        Response::TYPE_JSON,
                        Response::STATUS_ERROR
                    );
                }
            }
            if($object->request('password') && $object->request('password2')){
                $validate = User::validatePasswords($object);
                if($validate->is_valid){
                    $password = password_hash($object->request('password'),User::PASSWORD_ALGO, ['cost' => User::PASSWORD_COST]);
                    $data->set($uuid . '.password', $password);
                    $is_change = true;
                } else {
                    $error = [];
                    $error['validate']['password'] = $validate->test['password'];
                    return new Response(
                        $error,
                        Response::TYPE_JSON,
                        Response::STATUS_ERROR
                    );
                }
            }
            if($is_change){
                $data->write($url);
                $record = $data->get($uuid);
                unset($record->password);
                return new Response(
                    $record,
                    Response::TYPE_JSON
                );
            } else {
                $error = [];
                $error['error'] = 'Nothing has changed...';
                return new Response(
                    $error,
                    Response::TYPE_JSON,
                    Response::STATUS_ERROR
                );
            }
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: '. $uuid;
            return new Response($error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
    }

    public static function delete(App $object): Response
    {
        $uuid = $object->request('uuid');
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $record = $data->get($uuid);
        if($record){
            $data->set($uuid . '.isDeleted', microtime(true));
            $data->write($url);
            $record = $data->get($uuid);
            unset($record->password);
            return new Response(
                $record,
                Response::TYPE_JSON
            );
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: ' . $uuid;
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
    }

    public static function list(App $object){
        $limit = $object->request('limit') ? $object->request('limit') : 20;
        $start = Main::page($object, $limit);
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        } else {
          $index=0;
          $collect=false;
          $result = new Data();
          foreach($data->data() as $key => $record){
              if($index === $start){
                  $collect = true;
              }
              elseif($index >= $start + $limit){
                  $collect = false;
                  break;
              }
              if($collect){
                  $result->set($key, $record);
              }
              $index++;
          }
            return new Response(
                $result,
                Response::TYPE_JSON,
            );
        }
    }

    public static function readAttribute(App $object): Response
    {
        $uuid = $object->request('uuid');
        $attribute = $object->request('attribute');
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $record = $data->get($uuid);
        if($record){
            $node = $data->get($uuid . '.' . $attribute);
            if(isset($node)){
                return new Response(
                    $node,
                    Response::TYPE_JSON
                );
            } else {
                $error = [];
                $error['error'] = 'Could not find attribute (' . $attribute . ') in node with uuid: '. $uuid;
                return new Response(
                    $error,
                    Response::TYPE_JSON,
                    Response::STATUS_ERROR
                );
            }
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: '. $uuid;
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
    }

    public static function deleteAttribute(App $object): Response
    {
        $uuid = $object->request('uuid');
        $attribute_list = explode(',', $object->request('attribute'));
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            $error = [];
            $error['error'] = 'Could not read node file...';
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $record = $data->get($uuid);
        if($record){
            foreach($attribute_list as $nr => $attribute){
                $data->delete($uuid . '.' . $attribute);
            }
            $data->write($url);
            $record = $data->get($uuid);
            unset($record->password);
            return new Response(
                $record,
                Response::TYPE_JSON
            );
        } else {
            $error = [];
            $error['error'] = 'Could not find node with uuid: ' . $uuid;
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
    }

    private static function getValue($value=null){
        if(is_object($value)){
            foreach($value as $key_value => $value_value){
                $value->{$key_value} = User::getValue($value_value);
            }
        }
        elseif(is_array($value)){
            foreach($value as $key_value => $value_value){
                $value[$key_value] = User::getValue($value_value);
            }
        }
        elseif(is_numeric($value)){
            $value += 0;
        }
        elseif($value === 'true'){
            $value = true;
        }
        elseif($value === 'false'){
            $value = false;
        }
        elseif($value === 'null'){
            $value = null;
        }
        elseif(
            is_string($value) &&
            substr($value, 0, 1) === '{' &&
            substr($value, -1, 1) === '}'
        ){
            try {
                $value = Core::object($value, Core::OBJECT_OBJECT);
            } catch (ObjectException $e) {
            }
        }
        elseif(
            is_string($value) &&
            substr($value, 0, 1) === '[' &&
            substr($value, -1, 1) === ']'
        ){
            try {
                $value = Core::object($value, Core::OBJECT_ARRAY);
            } catch (ObjectException $e) {
            }
        }
        return $value;
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
        return rand(1000, 9999) .
            '-' .
            rand(1000, 9999) .
            '-' .
            rand(1000, 9999) .
            '-' .
            rand(1000, 9999) .
            '-' .
            rand(1000, 9999) .
            '-' .
            rand(1000, 9999);
    }

    private static function validatePasswords($object, $type='user')
    {
        $validate = Main::validate($object, User::getValidatorUrl($object), $type);
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

    private static function validateAttribute($object, $attribute, $type='user')
    {
        $validate = Main::validate($object, User::getValidatorUrl($object), $type);
        $is_valid = false;
        if($validate){
            $is_valid = true;
            if(!array_key_exists($attribute, $validate->test)){
                $validate->is_valid = $is_valid;
                return $validate;
            }
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
