<?php
namespace Host\Subdomain\Host\Extension\Service;


use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;
use R3m\Io\Module\Sort;

use Exception;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\ObjectException;

class User extends Main {
    const PASSWORD_ALGO = PASSWORD_BCRYPT;
    const PASSWORD_COST = 13;

    const BLOCK_EMAIL_COUNT = 5;
    const BLOCK_PASSWORD_COUNT = 5;

    const EXCEPTION_BLOCKED = 400;

    const DEFAULT_SORT = 'email';
    const DEFAULT_ORDER = 'ASC';
    const DEFAULT_LIMIT = 20;

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
                $role = $object->request('role');
                $data->set($uuid . '.uuid', $uuid);
                $data->set($uuid . '.email', $email);
                $data->set($uuid . '.password', $password);
                $data->set($uuid . '.isActive', false);
                $data->set($uuid . '.parameter.activation_code', User::generateActivationCode());
                $data->set($uuid . '.parameter.activation_expiration_date', strtotime('+1 day'));
                if($role){
                    $data->set($uuid . '.role', $role);
                }
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
        $limit = $object->request('limit') ? $object->request('limit') : User::DEFAULT_LIMIT;
        $sort = $object->request('sort') ? $object->request('sort') : User::DEFAULT_SORT;
        $order = $object->request('order') ? $object->request('order') : User::DEFAULT_ORDER;
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
            $sort = explode(',', $sort, 2);
            foreach($sort as $key => $value){
                $sort[$key] = trim($value, ' ');
            }
            $order = explode(',', $order, 2 );
            foreach($order as $key => $value){
                $order[$key] = trim($value, ' ');
            }
            $count = count($sort);
            $list = [];
            if($count === 1){
                $list = Sort::list($data->data())->with([$sort[0] => $order[0]]);
            }
            elseif($count === 2){
                $list = Sort::list($data->data())->with([$sort[0] => $order[0], $sort[1] => $order[1]]);
            }
            $index=0;
            $collect=false;
            $result = new Data();
            foreach($list as $key => $record){
                if($index === $start){
                    $collect = true;
                }
                elseif($index >= $start + $limit){
                    $collect = false;
                    break;
                }
                if($collect){
                    unset($record->password);
                    $result->set($key, $record);
                }
                $index++;
            }
            return new Response(
                $result->data(),
                Response::TYPE_JSON,
            );
        }
    }

    public static function activate(App $object){
        $uuid = $object->request('uuid');
        $activation_code = $object->request('activation_code');
        $activation_time = time();
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
        $code = $data->get($uuid . '.parameter.activation_code');
        $expiration_date = $data->get($uuid . '.parameter.activation_expiration_date');
        if(
            $record &&
            $activation_code == $code &&
            $activation_time <= $expiration_date
        ){
            $data->set($uuid . '.isActive', true);
            $data->delete($uuid . '.parameter.activation_code');
            $data->delete($uuid . '.parameter.activation_expiration_date');
            $data->write($url);
            $record = $data->get($uuid);
            return new Response(
                $record,
                Response::TYPE_JSON,
            );
        } else {
            $error = [];
            $error['error'] = 'Could not activate node with uuid: ' . $uuid;
            return new Response(
                $error,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
    }

    /**
     * @throws Exception
     */
    public static function login(App $object): Response
    {
        $node = User::getUserByEmail($object);
        if(
            $node &&
            property_exists($node, 'password') &&
            property_exists($node, 'uuid') &&
            property_exists($node, 'email')
        ){
            $password = $object->request('password');
            $verify = password_verify($password, $node->password);
            if(empty($verify)){
                UserLogger::log($object, $node, UserLogger::STATUS_INVALID_PASSWORD);
                throw new Exception('Invalid password.');
            }
            UserLogger::log($object, $node, UserLogger::STATUS_SUCCESS);
            $node = User::getTokens($object, $node);
            $response = [];
            $response['user'] = $node;
            return new Response(
                $response,
                Response::TYPE_JSON
            );
        } else {
            UserLogger::log($object, null, UserLogger::STATUS_INVALID_EMAIL);
            throw new Exception('Invalid e-mail.');
        }
    }

    /**
     * @throws AuthorizationException
     */
    public static function current(App $object): Response
    {
        $token = '';
        if(array_key_exists('HTTP_AUTHORIZATION', $_SERVER)){
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        }
        elseif(array_key_exists('REDIRECT_HTTP_AUTHORIZATION', $_SERVER)){
            $token = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        $token = substr($token , 7);
        if(!$token){
            throw new AuthorizationException('Please provide a valid token...');
        }
        $token_unencrypted = Jwt::decryptToken($object, $token);
        $claims = $token_unencrypted->claims();
        if($claims->has('user')){
            $user =  $claims->get('user');
            $uuid = false;
            $email = false;
            if(array_key_exists('uuid', $user)){
                $uuid = $user['uuid'];
            }
            if(array_key_exists('email', $user)){
                $email = $user['email'];
            }
            if($uuid && $email){
                $object->request('email', $email);
                $user = User::getUserByEmail($object);
                if(!property_exists($user, 'isActive')){
                    throw new AuthorizationException('User is not active...');
                }
                if($user->isActive !== true){
                    throw new AuthorizationException('User is not active...');
                }
                if(property_exists($user, 'isDeleted')){
                    throw new AuthorizationException('User is deleted...');
                }
                if(!property_exists($user, 'role')){
                    throw new AuthorizationException('User has no roles...');
                }
                if(count($user->role) === 0){
                    throw new AuthorizationException('User has no roles...');
                }
                unset($user->password);
                unset($user->refreshToken);
                $response = [];
                $response['user'] = $user;
                return new Response(
                    $response,
                    Response::TYPE_JSON
                );
            }
        }
        throw new AuthorizationException('Authentication failure... (invalid claim)');
    }

    public static function token(App $object){
        $configuration = Jwt::configuration($object);
        $node = User::getUserByEmail($object);
        dd($node);
        $options = [];
        $options['user'] = $node;
        $token = Jwt::get($object, $configuration, $options);
    }

    /**
     * @throws AuthorizationException
     * @throws Exception
     */
    public static function refresh_token(App $object): Response
    {
        $token = '';
        if(array_key_exists('HTTP_AUTHORIZATION', $_SERVER)){
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        }
        elseif(array_key_exists('REDIRECT_HTTP_AUTHORIZATION', $_SERVER)){
            $token = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        $token = substr($token , 7);
        if(!$token){
            throw new AuthorizationException('Please provide a valid token...');
        }
        $token_unencrypted = Jwt::decryptRefreshToken($object, $token);
        $claims = $token_unencrypted->claims();
        if($claims->has('user')){
            $user =  $claims->get('user');
            $uuid = false;
            $email = false;
            if(array_key_exists('uuid', $user)){
                $uuid = $user['uuid'];
            }
            if(array_key_exists('email', $user)){
                $email = $user['email'];
            }
            if($uuid && $email){
                $object->request('email', $email);
                $user = User::getUserByEmail($object);

                //add password signature for refeshToken to validate...
                $refreshToken = sha1($token);
                if(!property_exists($user, 'refreshToken')){
                    throw new AuthorizationException('Refresh token not present...');
                }
                if(!password_verify($refreshToken, $user->refreshToken)){
                    throw new AuthorizationException('Refresh token not valid...');
                }
                if(!property_exists($user, 'isActive')){
                    throw new AuthorizationException('User is not active...');
                }
                if($user->isActive !== true){
                    throw new AuthorizationException('User is not active...');
                }
                if(property_exists($user, 'isDeleted')){
                    throw new AuthorizationException('User is deleted...');
                }
                if(!property_exists($user, 'role')){
                    throw new AuthorizationException('User has no roles...');
                }
                if(count($user->role) === 0){
                    throw new AuthorizationException('User has no roles...');
                }
                unset($user->password);
                $user = User::getTokens($object, $user);
                //add token
                //add refreshToken
                $response = [];
                $response['user'] = $user;
                return new Response(
                    $response,
                    Response::TYPE_JSON
                );
            }
        }
        throw new AuthorizationException('Authentication failure... (invalid claim)');
    }

    public static function install(App $object){

    }

    public static function is_blocked(App $object): bool
    {
        $node = User::getUserByEmail($object);
        if($node){
            $count = UserLogger::count($object, $node, UserLogger::STATUS_INVALID_PASSWORD);
            if($count >= User::BLOCK_PASSWORD_COUNT){
                UserLogger::log($object, $node, UserLogger::STATUS_BLOCKED);
                return true;
            }
        } else {
            $count = UserLogger::count($object, null, UserLogger::STATUS_INVALID_EMAIL);
            if($count >= User::BLOCK_EMAIL_COUNT){
                UserLogger::log($object, null, UserLogger::STATUS_BLOCKED);
                return true;
            }
        }
        return false;
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

    /**
     * @throws Exception
     */
    private static function getTokens(App $object, stdClass $node): stdClass
    {
        $configuration = Jwt::configuration($object);
        $options = [];
        $options['user'] = $node;
        $token = Jwt::get($object, $configuration, $options);
        $token = $token->toString();
        $options['refresh'] = true;
        $configuration = Jwt::configuration($object, $options);
        $refreshToken = Jwt::refresh_get($object, $configuration, $options);
        $refreshToken = $refreshToken->toString();
        $node->refreshToken = sha1($refreshToken);
        $cost = 13;
        $node->refreshToken = password_hash($node->refreshToken, PASSWORD_BCRYPT, [
            'cost' => $cost
        ]);
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            throw new Exception('Invalid user data...');
        }
        $data->set($node->uuid . '.refreshToken', $node->refreshToken);
        $data->write($url);
        $node->token = $token;
        $node->refreshToken = $refreshToken;
        return $node;
    }

    public static function getUserByEmail(App $object)
    {
        $email = $object->request('email');
        $url = User::getDataUrl($object);
        $data = $object->data_read($url);
        if (!$data) {
            d($url);
            echo 'no data';
            return false;
        } else {
            $node = false;
            foreach ($data->data() as $uuid => $record) {
                if (
                    property_exists($record, 'isActive') &&
                    property_exists($record, 'email') &&
                    !property_exists($record, 'isDeleted') &&
                    $record->isActive === true &&
                    $record->email === $email
                ) {
                    $node = $record;
                    break;
                }
            }
            return $node;
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
