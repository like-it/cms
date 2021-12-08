<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;


use Host\Subdomain\Host\Extension\Service\Settings as Service;
use Host\Subdomain\Host\Extension\Service\Main;


class Settings extends Main {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function body(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }

    public static function email_settings(App $object): Response
    {
        return Service::email_list($object);
    }

    public static function email_add(App $object): Response
    {
        return Service::email_create($object);
    }

    private static function email_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Email' .
            $object->config('extension.json');
    }

    public static function email_account_default(App $object){
        return Service::email_account_default($object);
    }

    public static function email_command(App $object){
        $uuid = $object->request('uuid');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    return Service::email_delete($object, $uuid);
                case 'GET' :
                    return Service::email_read($object, $uuid);
                case 'PUT' :
                    return Service::email_update($object, $uuid);



                    d($object->request());
                    dd('post');
                    break;
            }
        } catch (Exception $exception) {
            return $exception;
        }




    }
}
