<?php
namespace Host\Subdomain\Host\Extension\Service;


use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;
use R3m\Io\Module\View;

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
        $validate = false;
        if($validate){
            if($validate->success === true){
                //we can create the user
                dd('create User');
            }
        } else {
            $error = [];
            $error['error'] = 'error: Validator did not received valid url...';
            return $error;
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
