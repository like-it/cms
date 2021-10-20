<?php
namespace Host\Subdomain\Host\Extension\Service;


use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class User extends Main {

    public static function create(App $object){

        $url = $object->config('host.dir.root') .
            'Node' .
            $object->config('ds') .
            'Validator' .
            $object->config('ds') .
            File::basename(__CLASS__) .
            $object->config('extension.json');

        $object->request('node.type', 'user');
        $validate = Main::validate($object, $url);
        if($validate){
            if($validate->success === true){
                //we can create the user
                dd('create User');
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

}
