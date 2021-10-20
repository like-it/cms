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

class User  {

    public static function create(App $object){

        //$data = new Data();
        //$data->set('email', $object->request('email'));

        $url = $object->data('controller.dir.data') . File::basename(__CLASS__) . $object->config('extension.json');

        dd($url);

        d($object->request());
        dd('create User');
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
