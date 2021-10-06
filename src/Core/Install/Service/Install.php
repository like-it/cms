<?php
namespace LikeIt\Cms\Core\Install\Service;

use JetBrains\PhpStorm\NoReturn;
use R3m\Io\App;

use Exception;
use R3m\Io\Module\File;
use R3m\Io\Module\Validate;

class Install {

    public static function start(App $object){
        $email = $object->request('email');
        $password = $object->request('password');
        $password2 = $object->request('password2');
        $domain = $object->request('domain');

        $url = $object->data('controller.dir.data') . File::basename(__CLASS__) . $object->config('extension.json');
        d($url);
        $object->request('node.type', 'user');
        $validate = Install::validate($object, $url);

        d($validate);


        dd($object->request());
    }

    public static function validate(App $object, $url){
        $data = $object->data(sha1($url));
        if($data === null){
            $data = $object->parse_read($url, sha1($url));
        }
        if($data){
            $validate = $data->data($object->request('node.type') . '.validate');
            try {
                return Validate::validate($object, $validate);
            } catch (Exception $e) {
                echo $e;
            }
        }
    }
}
